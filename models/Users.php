<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id
 * @property string $username
 * @property string $notification_token
 * @property string $first_name
 * @property string $last_name
 * @property int $type_id
 * @property int $phone
 * @property int $email
 * @property int $password
 * @property int $is_ative
 * @property int $branch_id
 *
 * @property ClassRoom[] $classRooms
 * @property Course[] $courses
 * @property Schedule[] $schedules
 * @property ClassRoom[] $classRooms0
 * @property Task[] $tasks
 * @property UserType $type
 * @property Branch $branch
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'first_name', 'last_name', 'type_id', 'phone', 'email', 'password', 'branch_id'], 'required'],
            [['notification_token'], 'string'],
            [['type_id', 'phone', 'email', 'password', 'is_ative', 'branch_id'], 'integer'],
            [['username', 'first_name', 'last_name'], 'string', 'max' => 255],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserType::className(), 'targetAttribute' => ['type_id' => 'id']],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'notification_token' => Yii::t('app', 'Notification Token'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'type_id' => Yii::t('app', 'Type ID'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'is_ative' => Yii::t('app', 'Is Ative'),
            'branch_id' => Yii::t('app', 'Branch ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassRooms()
    {
        return $this->hasMany(ClassRoom::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasMany(Course::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedules()
    {
        return $this->hasMany(Schedule::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassRooms0()
    {
        return $this->hasMany(ClassRoom::className(), ['id' => 'class_room_id'])->viaTable('{{%schedule}}', ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(UserType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }
}
