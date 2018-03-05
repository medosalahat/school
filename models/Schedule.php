<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%schedule}}".
 *
 * @property int $id
 * @property int $class_room_id
 * @property int $user_id
 * @property string $schedule_time
 * @property string $start_time
 * @property string $end_time
 * @property string $date
 * @property int $room_id
 *
 * @property ClassRoom $classRoom
 * @property Users $user
 * @property Rooms $room
 */
class Schedule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%schedule}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['class_room_id', 'user_id', 'schedule_time', 'start_time', 'end_time', 'date', 'room_id'], 'required'],
            [['class_room_id', 'user_id', 'room_id'], 'integer'],
            [['date'], 'safe'],
            [['schedule_time', 'start_time', 'end_time'], 'string', 'max' => 255],
            [['class_room_id', 'user_id'], 'unique', 'targetAttribute' => ['class_room_id', 'user_id']],
            [['class_room_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClassRoom::className(), 'targetAttribute' => ['class_room_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['room_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rooms::className(), 'targetAttribute' => ['room_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'class_room_id' => Yii::t('app', 'Class Room ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'schedule_time' => Yii::t('app', 'Schedule Time'),
            'start_time' => Yii::t('app', 'Start Time'),
            'end_time' => Yii::t('app', 'End Time'),
            'date' => Yii::t('app', 'Date'),
            'room_id' => Yii::t('app', 'Room ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassRoom()
    {
        return $this->hasOne(ClassRoom::className(), ['id' => 'class_room_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoom()
    {
        return $this->hasOne(Rooms::className(), ['id' => 'room_id']);
    }

    /**
     * {@inheritdoc}
     * @return ScheduleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ScheduleQuery(get_called_class());
    }
}
