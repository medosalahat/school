<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property int $class_room_id
 * @property string $task_details
 * @property int $user_id
 * @property string $task_date
 * @property string $task_note
 * @property int $is_active
 *
 * @property ClassRoom $classRoom
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
            [['class_room_id', 'task_details', 'user_id', 'task_date', 'task_note'], 'required'],
            [['class_room_id', 'user_id'], 'integer'],
            [['task_details', 'task_note'], 'string'],
            [['task_date'], 'safe'],
            [['is_active'], 'string', 'max' => 1],
            [['class_room_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClassRoom::className(), 'targetAttribute' => ['class_room_id' => 'id']],
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
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
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
     * @return TaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskQuery(get_called_class());
    }
}
