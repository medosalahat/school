<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "class_room".
 *
 * @property int $id
 * @property int $course_id
 * @property int $user_id

 * @property string $year
 * @property string $start_date
 * @property string $end_date
 * @property string $title
 *
 * @property Course $course
 * @property Users $user
 * @property ClassRoomDays[] $classRoomDays
 * @property Schedule[] $schedules

 */
class ClassRoom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'class_room';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id','user_id','title' ,'year', 'trem'], 'required'],
            [['course_id','user_id'], 'integer'],
            [['year','title'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'course_id' => Yii::t('app', 'Course ID'),
            'title' => Yii::t('app', 'Title'),

            'year' => Yii::t('app', 'Year'),
            'trem' => Yii::t('app', 'Trem'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassRoomDays()
    {
        return $this->hasMany(ClassRoomDays::className(), ['class_room_id' => 'id']);
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
    public function getSchedules()
    {
        return $this->hasMany(Schedule::className(), ['class_room_id' => 'id']);
    }



    /**
     * @inheritdoc
     * @return ClassRoomQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClassRoomQuery(get_called_class());
    }
}
