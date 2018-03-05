<?php
/**
 * Created by PhpStorm.
 * User: salahat
 * Date: 05/03/18
 * Time: 04:27 ص
 */
namespace app\controllers;
use app\models\Users;
use opensooq\firebase\FirebaseNotifications;
use yii\helpers\Json;
use yii\rest\ActiveController;
class NotificationsController extends ActiveController{

    public function actionIndex(){
        $service = new FirebaseNotifications(['authKey' => \Yii::$app->params['FirebaseNotifications']]);

        if(!\Yii::$app->request->getIsPost()){
            echo Json::encode(['valid'=>false,'status'=>400,'not found request']);
            die;
        }
        if(!\Yii::$app->request->post('user_id')){
            echo Json::encode(['valid'=>false,'status'=>400,'not found user id']);
            die;
        }

        if(!\Yii::$app->request->post('message')){
            echo Json::encode(['valid'=>false,'status'=>400,'not found message']);
            die;
        }

        $user = Users::find()->where(['id'=>\Yii::$app->request->post('user_id')])->one();

        if(empty($user)){
            echo Json::encode(['valid'=>false,'status'=>400,'user not found']);
            die;
        }
        $data= $service->sendNotification($user->notification_token, $user);

        echo Json::encode(['valid'=>true,'data'=>$data]);
    }

}