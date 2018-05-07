<?php
namespace app\controllers;
use PharIo\Manifest\Url;
use yii\rest\ActiveController;
use yii;
class CourseController extends ActiveController{
    public $modelClass = 'app\models\Course';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
    public function actions() {
        $actions = parent::actions();
        unset($actions[ 'index']);
        unset($actions[ 'create']);
        return $actions;
    }
    public function actionCreate()
    {
        /* @var $model \yii\db\ActiveRecord */
        $model = new $this->modelClass();

        $model->image = yii\web\UploadedFile::getInstanceByName('image');
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if (Yii::$app->request->isPost) {
            $image = $model->upload();
            $model->image = $image ;
                if ($model->save(true,['name','user_id','details','branch_id','image'])) {
                    $response = Yii::$app->getResponse();
                    $response->setStatusCode(201);
                    $id = implode(',', array_values($model->getPrimaryKey(true)));
                    $response->getHeaders()->set('Location', yii\helpers\Url::toRoute(['view', 'id' => $id], true));
                } elseif (!$model->hasErrors()) {
                    throw new yii\web\ServerErrorHttpException('Failed to create the object for unknown reason.');
                }

        }

        return $model;
    }
    public $prepareDataProvider;
    public $dataFilter;

    public function actionIndex() {
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }

        $filter = null;
        if ($this->dataFilter !== null) {
            $this->dataFilter = Yii::createObject($this->dataFilter);
            if ($this->dataFilter->load($requestParams)) {
                $filter = $this->dataFilter->build();
                if ($filter === false) {
                    return $this->dataFilter;
                }
            }
        }

        if ($this->prepareDataProvider !== null) {
            return call_user_func($this->prepareDataProvider, $this, $filter);
        }

        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = $this->modelClass;

        $query = $modelClass::find();

        if (!empty($filter)) {
            $query->andWhere($filter);
        }
        $query->with(['classRooms','classRoomDays','user','branch','tasks']);




        return Yii::createObject([
            'class' => yii\data\ActiveDataProvider::className(),
            'query' => $query,
            'pagination' => [
                'params' => $requestParams,
            ],
            'sort' => [
                'params' => $requestParams,
            ],
        ]);
    }
}