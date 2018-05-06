<?php
namespace app\controllers;
use app\models\PasswordForm;
use app\models\Users;
use sngrl\PhpFirebaseCloudMessaging\Client;
use sngrl\PhpFirebaseCloudMessaging\Message;
use sngrl\PhpFirebaseCloudMessaging\Notification;
use sngrl\PhpFirebaseCloudMessaging\Recipient\Device;
use yii\rest\ActiveController;
use yii;
class UsersController extends ActiveController{
    public $modelClass = 'app\models\Users';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function actions() {
        $actions = parent::actions();
        unset($actions[ 'index']);
        return $actions;
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
        $query->with(['classRooms','courses','schedules','classRooms0','tasks','type','branch']);




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

    public function actionType($id){
        return Users::find()->where(['type_id'=>$id])->all();

    }

    public function actionLogin(){

        if(\Yii::$app->request->getIsPost()){
            $username = \Yii::$app->request->post('username');
            $password = \Yii::$app->request->post('password');

            return ['user'=>Users::find()->where(['username'=>$username,'password'=>sha1($password)])->one()];

        }
        return ['valid'=>false,'message'=>'please check is post request'];

    }

    public function actionValid_password(){

        $model = new PasswordForm();
        if(\Yii::$app->request->getIsPost()){
            $model->password = \Yii::$app->request->post('password');
        }
        if($model->validate()){
            return $model;
        }
        return $model;

    }

    public function actionSchedule(){

        if(\Yii::$app->request->getIsPost()){
            if(\Yii::$app->request->post('id') and \Yii::$app->request->post('day')){
                $id= \Yii::$app->request->post('id');
                $day= \Yii::$app->request->post('day');
                $user = Users::findOne(['id'=>$id]);
                if(empty($user)){
                    return ['valid'=>false,'message'=>'please check user id '];
                }
                $query = new \yii\db\Query;
                $query->
                select([
                        'rooms.name as room',
                        'course.name as course',
                        'users.username as teacher',
                        'class_room_days.start_time',
                        'class_room_days.end_time',
                        'class_room_days.day',
                        'branch.name as branch_name',
                        'branch.location as branch_location',
                    ])->
                from('schedule')->
                innerJoin('rooms','rooms.id = schedule.room_id')->
                innerJoin('class_room','class_room.id = schedule.class_room_id')->
                innerJoin('course','course.id = class_room.course_id')->
                innerJoin('branch','branch.id = course.branch_id')->
                innerJoin('users','users.id = course.user_id')->
                innerJoin('class_room_days','class_room_days.class_room_id = class_room.id')->
                    where(['schedule.user_id'=>$user->id,'class_room_days.day'=>$day])->
                createCommand();
                return $query->all();
            }else{
                return ['valid'=>false,'message'=>'please check user id or day '];
            }
        }else{
            return ['valid'=>false,'message'=>'please check is post request'];
        }
    }

    public function actionNotifications(){
        if(!\Yii::$app->request->getIsPost()){
            return ['valid'=>false,'status'=>400,'message'=>'not found request'];

        }
        if(!\Yii::$app->request->post('user_id')){
            return ['valid'=>false,'status'=>400,'message'=>'not found user id'];

        }

        if(!\Yii::$app->request->post('message')){
            return ['valid'=>false,'status'=>400,'message'=>'not found message'];

        }

        $user = Users::find()->where(['id'=>\Yii::$app->request->post('user_id')])->one();

        if(empty($user)){
            return ['valid'=>false,'status'=>400,'message'=>'user not found'];

        }

        $server_key = \Yii::$app->params['FirebaseNotifications'];
        $client = new Client();
        $client->setApiKey($server_key);
        $client->injectGuzzleHttpClient(new \GuzzleHttp\Client());

        $message = new Message();
        $message->setPriority('high');
        $message->addRecipient(new Device($user->notification_token));
        $message
            ->setNotification(new Notification('notification',\Yii::$app->request->post('message')))
            //->setData(['key' => 'value'])
        ;

        $response = $client->send($message);
        return ['status'=>$response->getStatusCode(),'body'=>$response->getBody()];
    }
}