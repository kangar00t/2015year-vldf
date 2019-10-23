<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

//use app\controllers\BaseController;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ConfirmEmailForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use app\models\Game;
use app\models\News;
use app\models\Diary;
use app\models\Option;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;

class SiteController extends Controller
{
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['set-option', 'rbac'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [ 
                        'actions' => ['login', 'request-password-reset', 'reset-password', 'signup', 'confirm-email'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'captcha', 'error', 'diary-old', 'about', 'contact', 'turnirshop'],
                    ],
                    
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ],
        ];
    }
    
    public function actionIndex()
    {
        $games = Game::find()->where('TO_DAYS(NOW()) - TO_DAYS(date) <= 7')->orderBy('date, field_id, time')->groupBy('date')->All();

        return $this->render('index', [
            'games' => $games,
            'news' => News::find()->where(['status' => 3])->one(),
            'diary' => Diary::find()->orderBy('id DESC')->one(),
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
 
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                Yii::$app->getSession()->setFlash('success', 'Подтвердите ваш электронный адрес.');
                return $this->goHome();
            }
        }
 
        return $this->render('signup', [
            'model' => $model,
        ]);
    }
    
    public function actionConfirmEmail($token)
    {
        try {
            $model = new ConfirmEmailForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
 
        if ($model->confirmEmail()) {
            Yii::$app->getSession()->setFlash('success', 'Спасибо! Ваш Email успешно подтверждён.');
        } else {
            Yii::$app->getSession()->setFlash('error', 'Ошибка подтверждения Email.');
        }
 
        return $this->goHome();
    }
 
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Спасибо! На ваш Email было отправлено письмо со ссылкой на восстановление пароля.');
 
                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Извините. У нас возникли проблемы с отправкой.');
            }
        }
 
        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }
 
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
 
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'Спасибо! Пароль успешно изменён.');
 
            return $this->goHome();
        }
 
        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionContact()
    {

        return $this->render('contact');
    }

    public function actionAbout()
    {
        Yii::$app->telegram->sendMessage(['chat_id' => '@suhomyatka', 'text' => 'UX Test']);
        echo '1';
    }
    
    public function actionDiaryOld()
    {
        return $this->render('diary');
    }
        
    public function successCallback($client)
    {
        $attributes = $client->getUserAttributes();
        var_dump($attributes);
        die();
        // user login or signup comes here
    }    

    public function actionSetOption()
    {
        $name = $_POST["name"];
        $value = $_POST["value"];

        $options = Option::find()->where(['name' => $name])->all();

        if (count($options)) {
            foreach ($options as $option) {
                $option->value = +$value;
                echo $option->save();
            }
            echo 'ok!';
        }
    }

    public function actionTurnirshop($id)
    {
        require(__DIR__ . '/../import/excel/PHPExcel.php');
        $pExcel = \PHPExcel_IOFactory::load(__DIR__ . '/../import/files/'.$id.'.xls');

        foreach ($pExcel->getWorksheetIterator() as $worksheet) {
            $tables[] = $worksheet->toArray();
        }

        $m = [];
        $t = 0;
        foreach( $tables as $table ) {
            $t++;
            $r = 0;
            foreach($table as $row) {
                $r++;
                $c = 0;
                foreach( $row as $col ) {
                    $c++;
                    $m[$t][$r][$c] = $col;
                }
            }
        }


        if ($id = 2) {
            $i = 0;
            echo '<table border="1">';
            // Цикл по строкам
            foreach($m[1] as $row) {
            	$j = 0;
            	$i++;
                if (!$row[1] && ($i>8)) {
                    echo '<tr>';
                    // Цикл по колонкам
                    foreach( $row as $col ) {
                    	$j++;
                        echo '<td>('.$i.'-'.$j.')'.$col.'</td>';
                    }
                    echo '</tr>';
                }
            }
            echo '</table>';
        }


    }

    public function actionRbac() {
        
        $auth = Yii::$app->authManager;

        $admin = $auth->getRole('admin');
        $task = $auth->getRole('task');
        
        //$timeManager = $auth->createPermission('timeManager');
        //$auth->add($timeManager);
        //$auth->addChild($admin, $timeManager);

        $timeManager = $auth->getPermission('timeManager');

        //$diaryManager = $auth->createPermission('diaryManager');
        //$auth->add($diaryManager);
        //$auth->addChild($admin, $diaryManager);

        $diaryManager = $auth->getPermission('diaryManager');

        //$teamListManager = $auth->createPermission('teamListManager');
        //$auth->add($teamListManager);
        //$auth->addChild($admin, $teamListManager);

        $teamListManager = $auth->getPermission('teamListManager');

        //$gameManager = $auth->createPermission('gameManager');
        //$auth->add($gameManager);
        //$auth->addChild($admin, $gameManager);

        $gameManager = $auth->getPermission('gameManager');

    }
}
