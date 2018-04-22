<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "class_room".
 *
 * @property int $id
 * @property int $course_id

 * @property string $year
 * @property string $trem
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
            [['course_id', 'year', 'trem'], 'required'],
            [['course_id'], 'integer'],
            [['year', 'trem'], 'string', 'max' => 255],
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
