<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "course".
 *
 * @property int $id
 * @property string $name
 * @property string $details
 * @property int $branch_id
 * @property string $image
 *
 * @property ClassRoom[] $classRooms
 * @property ClassRoomDays[] $classRoomDays

 * @property Branch $branch
 * @property Task[] $tasks
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['details', 'branch_id'], 'required'],
            [[  'branch_id'], 'integer'],
            [['details'], 'string'],
           // [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png,jpg'],

            [['name'], 'string', 'max' => 255],
           // [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'id']],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $file= '/uploads/' . time().sha1(time()) . '.' . $this->image->extension;

            $this->image->saveAs(__DIR__.'/..'.$file);
            $this->image= $file;
            return $file;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),

            'details' => Yii::t('app', 'Details'),
            'branch_id' => Yii::t('app', 'Branch ID'),
            'image' => Yii::t('app', 'image'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassRooms()
    {
        return $this->hasMany(ClassRoom::className(), ['course_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassRoomDays()
    {
        return $this->hasMany(ClassRoomDays::className(), ['course_id' => 'id']);
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
    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['course_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CourseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CourseQuery(get_called_class());
    }
}
