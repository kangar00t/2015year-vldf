<?php

namespace app\controllers;

use Yii;
use yii\BaseYii;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use app\models\User;
use app\models\Profile;
use app\models\TeamList;
use app\models\Names;
use app\models\Diary;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class ProfileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['delete', 'create', 'update', 'scan', 'restart'],
                    'rules' => [
                        [
                            'actions' => ['delete', 'create', 'scan', 'restart'],
                            'allow' => true,
                            'roles' => ['admin'],
                        ],
                        [
                            'actions' => ['update'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'find' => ['post'],
                ],
            ],
        ];
    }


    public function actionRestart() {
        
        $k=0;
        foreach (Profile::find()->all() as $profile) {
            //If ($profile2 = Profile::find()->where(['fname' => $profile->lname])->one()) {
            If (!count(Names::find()->where(['name' => $profile->fname])->all())) {
                    echo '<p>'.$profile->link.'</p>';
                    $k++;
                                                                              

                
                
            }
                    
        }
        echo $k;
        
        /*foreach (Names::find()->all() as $name) {
            echo $name->name;
            $name->name = trim($name->name);
            $name->save();
        }*/
    }
    
    
    public function actionIndex()
    {   
        return $this->render('index');
    }

    public function actionEmail()
    {   
        echo '<table>';
        Foreach (Profile::find()->where('user_id > 0 AND lname <> ""')->all() as $profile) {
            $i++;
            echo '<tr><td>'.$i.'</td><td>'.$profile->user->email.'</td><td>'.$profile->fullName.'</td></tr>';
        }
        echo '</table>';
    }
    
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    
    public function actionCreate()
    {
        $model = new Profile();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {

        $model = $this->findModel($id);
        
        $access_lvl = 0;
        If ($model->canUpdate()) $access_lvl = 1;
        If ($id == Yii::$app->user->identity->profile_id) $access_lvl = 2;
        If (Yii::$app->user->can('admin')) $access_lvl = 3;
        
        $fname = $model->fname;
        $lname = $model->lname;
        $sname = $model->sname;
        If ($access_lvl) {

            $dir = Yii::getAlias('@app/img/avatars/');

            if ($model->load(Yii::$app->request->post())) {

                If ($file = UploadedFile::getInstances($model, 'logo3')) {
                    $model->logo3 = $file[0];
                    $format = mb_strtolower(pathinfo($model->logo3, PATHINFO_EXTENSION)); 
                } else 
                    $model->logo3 = NULL;
                
                If ($access_lvl < 2) {
                    $model->fname = $fname;
                    $model->lname = $lname;
                    $model->sname = $sname;
                }
                If ($model->validate()) {
                    If ($model->logo3)
                        $model->photo = 'ava_'.$model->id; 
                    If ($model->save()) {
                        If ($model->logo3)
                            $update = $model->logo3->saveAs($dir.$model->photo.'.'.$format);
                        
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } else return $this->redirect(['view', 'id' => $model->id]);
                
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'a_lvl' => $access_lvl,
                ]);
            }





        } else {
            throw new \yii\web\HttpException(403, 'Редактирование чужого профиля запрещено.');
        }
        
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionScan() {
        if (isset($_POST['isscan'])) {
            $isscan  = $_POST['isscan'];
            $p_id = $_POST['p_id'];
            $profile = Profile::findOne($p_id);
            If ($isscan === 'true') $profile->status = 0;
            else $profile->status = 1;
            $profile->save();
            echo $profile->status;
        } else
        return $this->render('scan', [
            'tlists' => TeamList::find()->where(['turnir_id' => [807,808,809,810]])->All(),
        ]);
    }
    public function actionSearch()
    {

        if (isset($_POST['lname']) AND $_POST['lname']) {

            $lname = $_POST['lname'];
            if (isset($_POST['fname']) AND $_POST['fname']) {
                $fname = $_POST['fname'];
                $profiles = Profile::find()->where(['lname' => $lname, 'fname' => $fname])->All();
            } 
            else
                $profiles = Profile::find()->where(['lname' => $lname])->All();
                
            echo $this->renderPartial('search', [
                'profiles' => $profiles,
            ]);
        }
    }
    
    public function actionFind()
    {

        if (isset($_POST['lname']) AND $_POST['lname']) {

            $lname = $_POST['lname'];
            if (isset($_POST['fname']) AND $_POST['fname']) {
                $fname = $_POST['fname'];
                $profiles = Profile::find()->where(['lname' => $lname, 'fname' => $fname])->All();
            } 
            else
                $profiles = Profile::find()->where(['lname' => $lname])->All();
                
            echo $this->renderPartial('find', [
                'profiles' => $profiles,
            ]);
        }
    }

    protected function findModel($id)
    {
        if (($model = Profile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
