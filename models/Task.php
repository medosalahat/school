<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property int $course_id
 * @property string $task_details
 * @property int $user_id
 * @property string $task_date
 * @property string $task_note
 * @property int $is_active
 *
 * @property Course $course
 * @property Users $user
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'task_details', 'user_id', 'task_date', 'task_note'], 'required'],
            [['course_id', 'user_id'], 'integer'],
            [['task_details', 'task_note'], 'string'],
            [['task_date'], 'safe'],
            [['is_active'], 'string', 'max' => 1],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'task_details' => Yii::t('app', 'Task Details'),
            'user_id' => Yii::t('app', 'User ID'),
            'task_date' => Yii::t('app', 'Task Date'),
            'task_note' => Yii::t('app', 'Task Note'),
            'is_active' => Yii::t('app', 'Is Active'),
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
     * @inheritdoc
     * @return TaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskQuery(get_called_class());
    }
}
