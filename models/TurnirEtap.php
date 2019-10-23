<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%turnir_etap}}".
 *
 * @property integer $id
 * @property integer $turnir_id
 * @property integer $stage_id
 * @property integer $steps
 * @property integer $type
 * @property string $name
 * @property integer $size
 */
class TurnirEtap extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 0;
    
    const STATUS_TABLED = 1;
    const STATUS_GAMED = 2;
    
    const STATUS_DELETE = 9;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%turnir_etap}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['turnir_id', 'stage_id', 'steps', 'type', 'size', 'game3'], 'required'],
            [['turnir_id', 'stage_id', 'steps', 'type', 'size', 'sort', 'game3'], 'integer'],
            [['steps'], 'integer', 'min' => 1, 'max' => 64],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'turnir_id' => 'Турнир',
            'stage_id' => 'Этап',
            'steps' => 'Круги',
            'type' => 'Тип',
            'name' => 'Название',
            'size' => 'Команд/стадий',
            'sort' => 'Сортировка',
            'game3' => 'Матч за 3 место',
        ];
    }
    
    public function getTurnirTeams()
    {
        return $this->hasMany(TurnirTeam::className(), ['etap_id' => 'id'])->orderBy('position');
    }
    
    public function getTurnir()
    {
        return $this->hasOne(Turnir::className(), ['id' => 'turnir_id']);
    }
    
    public function getTeams()
    {
        return $this->hasMany(Team::className(),['id' => 'team_id'])
                ->via('turnirTeams')->orderBy('id');
    }
    
    public function getTurnirTable()
    {
        return $this->hasMany(TurnirTable::className(),['tteam_id' => 'id'])
                ->via('turnirTeams')->orderBy('och DESC, pob DESC, lv DESC, lr DESC, razn DESC, zab DESC');
    }
    
    public function getGames()
    {
        return $this->hasMany(Game::className(), ['etap_id' => 'id'])->orderBy('tur');
    }
    
    public function getGamesOfDate()
    {
        return Game::find()->where(['etap_id' => $this->id])->orderBy('date')->All();
    }
    
    public function isStaffed() {
        If ($this->type == 1)
            return (count($this->teams) == $this->teamCountMax())? TRUE : FALSE;
        elseIf ($this->type == 2)
            return (count($this->teams) <= $this->teamCountMax()) AND (count($this->teams) > $this->teamCountMax()/2);
    }
    
    public function isTable() {
        If ($this->type == 1)
            return (count($this->turnirTable) == $this->size)? TRUE : FALSE;
        else {
            $isnorm = true;
            For ($i=100;$i<=$this->teamCountMax()*50;$i+=100) {
                $count = TurnirTeam::find()
                    ->where([
                        'etap_id' => $this->id,
                        'position' => $i,
                        ])
                    ->count();
                    
                If (!$count OR $count>2) $isnorm = false;
            }
            return $isnorm;
        }
    }
    
    public function playOffTable() {
        
        $tur = 1;
        $playoff=$this->size;
        $iteam=0;//порядковый номер
        For ($i=100;$i<=$this->teamCountMax()*50;$i+=100) {
            $tteam = TurnirTeam::find()
                ->where([
                    'etap_id' => $this->id,
                    'position' => $i,
                    ])
                ->all();
            //добавляем первую команду в массив
            If (count($tteam)) {
                $iteam++;
                $mas['table'][$playoff][$iteam] = $tteam[0]->team;
            } else {
                return 'no teams';
            }
            //если нет пары у команды
            If (count($tteam) == 1) {
                $iteam++;
                $mas['table'][$playoff][$iteam] = 0;
                //команда проходит в следующий этап
                $mas['table'][$playoff-1][$iteam/2] = $mas['table'][$playoff][$iteam-1];
            }
            elseif (count($tteam) == 2) {
                $iteam++;
                $mas['table'][$playoff][$iteam] = $tteam[1]->team;
                $tid1 = $mas['table'][$playoff][$iteam-1]->id;
                $tid2 = $mas['table'][$playoff][$iteam]->id;
                
                //если пара есть, будем проверять игры и определять прошедшую дальше команду
                $game = Game::find()
                    ->where([
                        'etap_id' => $this->id,
                        'tur' => $tur,
                        'team1_id' => ['or', $tid1, $tid2],
                        'team2_id' => ['or', $tid1, $tid2],
                    ])
                    ->one();
                If ($game) {
                    If ($tid1 == $game->team1_id) {
                        $mas['gol'][$playoff][$iteam-1] = $game->gol1;
                        $mas['gol'][$playoff][$iteam] = $game->gol2;
                    } elseIf ($tid1 == $game->team2_id) {
                        $mas['gol'][$playoff][$iteam-1] = $game->gol2;
                        $mas['gol'][$playoff][$iteam] = $game->gol1;
                    }
                    $mas['game'][$playoff][$iteam-1] = $game->id;
                    $mas['game'][$playoff][$iteam] = $game->id;
                    
                    If ($game->winner()) {
                        $mas['table'][$playoff-1][$iteam/2] = $game->winner();
                    }
                } else {
                   $game = new Game();
                    $game->team1_id = $tid1;
                    $game->team2_id = $tid2;
                    $game->turnir_id = $this->turnir_id;
                    $game->etap_id = $this->id;
                    $game->tur = $tur;
                    $game->save();
                }
                
            } else {
                return 'many teams';
            }

        }
        
        //теперь будем перебирать все этапы выше ($playoff - меньше) первого
        //перебираем до финала, т.к. там победителя дальше обрабатывать не нужно
        If ($this->size > 1)
            For ($playoff = $this->size - 1; $playoff > 0; $playoff--) {
                //тур в плэй-офф - порядок стадии, начиная с самой дальней от финала
                $tur++;
                //команд стало в два раза меньше
                $kteam = $this->TeamCountMax()/2;
                //пар команд в два раза меньше, чем самих команд. Перебираем пары
                For ($i=1;$i<=$kteam/2;$i++) {
                    $tid1=$mas['table'][$playoff][$i*2-1]->id;
                    $tid2=$mas['table'][$playoff][$i*2]->id;
                    
                    $game = Game::find()
                        ->where([
                            'etap_id' => $this->id,
                            'tur' => $tur,
                            'team1_id' => ['or', $tid1, $tid2],
                            'team2_id' => ['or', $tid1, $tid2],
                        ])
                        ->one();
                    If ($game) {
                        If ($tid1 == $game->team1_id) {
                            $mas['gol'][$playoff][$i*2-1] = $game->gol1;
                            $mas['gol'][$playoff][$i*2] = $game->gol2;
                        } elseIf ($tid1 == $game->team2_id) {
                            $mas['gol'][$playoff][$i*2-1] = $game->gol2;
                            $mas['gol'][$playoff][$i*2] = $game->gol1;
                        }
                        $mas['game'][$playoff][$i*2-1] = $game->id;
                        $mas['game'][$playoff][$i*2] = $game->id;
                        If ($game->winner()) {
                            if ($playoff-1 > 0)
                                $mas['table'][$playoff-1][$i] = $game->winner();

                            //если полуфинал и есть игра за 3 место, сохраняем проигравшие команды
                            if ($this->game3 AND $playoff == 2) {
                                $mas['table'][0][] = ($game->team1_id == $game->winner()->id) ? $game->team2_id : $game->team1_id;
                            }
                        }
                    } elseif ($tid1 && $tid2) {
                        $game = new Game();
                        $game->team1_id = $tid1;
                        $game->team2_id = $tid2;
                        $game->turnir_id = $this->turnir_id;
                        $game->etap_id = $this->id;
                        $game->tur = $tur;
                        $game->save();
                    }
                }
            }

            //добавление игры за 3 место
            if (count($mas['table'][0]) == 2) {
                $game = Game::find()
                ->where([
                    'etap_id' => $this->id,
                    'tur' => 0,
                    'team1_id' => ['or', $mas['table'][0][0], $mas['table'][0][1]],
                    'team2_id' => ['or', $mas['table'][0][0], $mas['table'][0][1] ],
                ])
                ->one();

                If ($game) {
                    $mas['game'][0] = $game->id;
                } else {
                    $game = new Game();
                    $game->team1_id = $mas['table'][0][0];
                    $game->team2_id = $mas['table'][0][1];
                    $game->turnir_id = $this->turnir_id;
                    $game->etap_id = $this->id;
                    $game->tur = 0;
                    $game->save();
                    $mas['game'][0] = $game->id;
                }
            }
        
        return $mas;
    }
    
    public function TeamCountMax() {
        If ($this->type == 1)
            return $this->size;
        elseif ($this->type == 2) {
            $count = 1;
            For ($i=1;$i<=$this->size;$i++) {
                $count = $count*2;
            }
            return $count;
        }
    }
    public function PositionArray() {
        $array = [];
        If ($this->type == 1) {
            for ($i=1; $i<=$this->TeamCountMax();$i++) {
                $array[$i] = ['id' => $i, 'name' => $i];
            }
        } else {
            for ($i=1; $i<=$this->TeamCountMax();$i=$i+2) {
                $array[$i] = ['id' => ($i+1)*100/2, 'name' => (($i+1)/2).'-ая пара'];
            }
        }
        return $array;
        
    }
    
    public function updateLvOch() {
        
        $och = 0; //очки равных команд
        $kteam = 1;//количество равных по очкам команд
        foreach ($this->turnirTable as $ttable) {
            //если нет равных, команду в первый элемент массива
            //If ($kteam < 2) $mas[$kteam] = $ttable;
            If ($ttable->och AND ($ttable->och == $och)) {
                //если есть равная, дописываем в массив
                $kteam++;
                $mas[$kteam] = $ttable;
            } else {
                //если массив одинаковых не пуст, будем искать их личные встречи
                If ($kteam > 1) {
                    
                    For ($i = 1; $i < $kteam; $i++)
                        For ($j = $i+1; $j <= $kteam; $j++) {
                            //die($mas[$i]->team_id.'-'.$mas[$j]->team_id);
                            If ($game = Game::findFromTurnirTable($mas[$i],$mas[$j]))
                                If ($game->winner()->id) {
                                    If ($game->winner()->id == $mas[$i]->team_id)
                                        $mas_och[$i] = $mas_och[$i]+3;
                                    else 
                                        $mas_och[$j] = $mas_och[$j]+3;
                                } else {
                                    $mas_och[$i] = $mas_och[$i]+1;
                                    $mas_och[$j] = $mas_och[$j]+1;
                                }
                            //var_dump($mas[$i]);
                            
                        }
                    
                    For ($i = 1; $i <= $kteam; $i++) {
                        $mas[$i]->lv = $mas_och[$i];
                        $mas[$i]->save();
                    }
                    
                    $kteam=1;
                    $mas_och = [];
                    $mas = [];
                }
                $och = $ttable->och;
                $mas[$kteam] = $ttable;
            }
        }
        
        // и еще раз проверим для последней команды, если она ровна по очкам с вышестоящей
        If ($kteam > 1) {
            For ($i = 1; $i < $kteam; $i++)
                For ($j = $i+1; $j <= $kteam; $j++) {
                    //die($mas[$i]->team_id.'-'.$mas[$j]->team_id);
                    If ($game = Game::findFromTurnirTable($mas[$i],$mas[$j]))
                        If ($game->winner()->id) {
                            If ($game->winner()->id == $mas[$i]->team_id)
                                $mas_och[$i] = $mas_och[$i]+3;
                            else 
                                $mas_och[$j] = $mas_och[$j]+3;
                        } else {
                            $mas_och[$i] = $mas_och[$i]+1;
                            $mas_och[$j] = $mas_och[$j]+1;
                        }
                    //var_dump($mas[$i]);
                    
                }
            
            For ($i = 1; $i <= $kteam; $i++) {
                $mas[$i]->lv = $mas_och[$i];
                $mas[$i]->save();
            }
            
            $kteam=1;
            $mas_och = [];
            $mas = [];
        }
    }
}
