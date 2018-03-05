<?php
namespace app\controllers;
use yii\rest\ActiveController;
class Class_roomsController extends ActiveController{
    public $modelClass = 'app\models\ClassRoom';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
}