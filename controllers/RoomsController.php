<?php
namespace app\controllers;
use yii\rest\ActiveController;
class RoomsController extends ActiveController{
    public $modelClass = 'app\models\Rooms';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

}