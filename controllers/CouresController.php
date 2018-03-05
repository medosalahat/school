<?php
namespace app\controllers;
use yii\rest\ActiveController;
class CourseController extends ActiveController{
    public $modelClass = 'app\models\Course';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
}