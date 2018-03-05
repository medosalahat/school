<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%class_room}}".
 *
 * @property int $id
 * @property int $course_id
 * @property int $user_id
 * @property string $time
 * @property string $year
 * @property string $trem
 * @property string $days
 *
 * @property Course $course
 * @property Users $user
 */
class ClassRoom extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%class_room}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['course_id', 'user_id', 'time', 'year', 'trem', 'days'], 'required'],
            [['course_id', 'user_id'], 'integer'],
            [['time', 'year', 'trem', 'days'], 'string', 'max' => 255],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'course_id' => Yii::t('app', 'Course ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'time' => Yii::t('app', 'Time'),
            'year' => Yii::t('app', 'Year'),
            'trem' => Yii::t('app', 'Trem'),
            'days' => Yii::t('app', 'Days'),
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
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return ClassRoomQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClassRoomQuery(get_called_class());
    }
}
