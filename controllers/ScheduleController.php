<?php
namespace app\controllers;
use yii\rest\ActiveController;
class ScheduleController extends ActiveController{
    public $modelClass = 'app\models\Schedule';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
}