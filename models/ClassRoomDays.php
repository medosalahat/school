<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "class_room_days".
 *
 * @property int $id
 * @property int $class_room_id
 * @property string $start_time
 * @property string $end_time
 * @property string $day
 *
 * @property ClassRoom $classRoom
 */
class ClassRoomDays extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'class_room_days';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['class_room_id', 'course_id', 'start_time', 'end_time'], 'required'],
            [['class_room_id', 'course_id'], 'integer'],
            [['start_time', 'end_time'], 'safe'],
            [['day'], 'string'],
            [['class_room_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClassRoom::className(), 'targetAttribute' => ['class_room_id' => 'id']],
           // [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'class_room_id' => Yii::t('app', 'Class Room ID'),

            'start_time' => Yii::t('app', 'Start Time'),
            'end_time' => Yii::t('app', 'End Time'),
            'day' => Yii::t('app', 'Day'),
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
     * @inheritdoc
     * @return ClassRoomDaysQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClassRoomDaysQuery(get_called_class());
    }
}
