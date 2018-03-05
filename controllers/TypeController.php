<?php
namespace app\controllers;
use yii\rest\ActiveController;
class TypeController extends ActiveController{
    public $modelClass = 'app\models\UserType';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
}