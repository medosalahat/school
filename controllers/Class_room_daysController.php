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
class Class_room_daysController extends ActiveController{
    public $modelClass = 'app\models\Class_room_days';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

}