<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%course}}".
 *
 * @property int $id
 * @property string $name
 * @property string $date
 * @property int $user_id
 * @property string $time
 * @property string $days
 * @property string $term
 * @property string $details
 * @property int $branch_id
 *
 * @property Users $user
 * @property Branch $branch
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%course}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'time'], 'safe'],
            [['user_id', 'time', 'days', 'term', 'details', 'branch_id'], 'required'],
            [['user_id', 'branch_id'], 'integer'],
            [['term', 'details'], 'string'],
            [['name', 'days'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'name' => Yii::t('app', 'Name'),
            'date' => Yii::t('app', 'Date'),
            'user_id' => Yii::t('app', 'User ID'),
            'time' => Yii::t('app', 'Time'),
            'days' => Yii::t('app', 'Days'),
            'term' => Yii::t('app', 'Term'),
            'details' => Yii::t('app', 'Details'),
            'branch_id' => Yii::t('app', 'Branch ID'),
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
    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
    }

    /**
     * {@inheritdoc}
     * @return CourseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CourseQuery(get_called_class());
    }
}
