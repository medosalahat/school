<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%rooms}}".
 *
 * @property int $id
 * @property string $name
 *
 * @property Schedule[] $schedules
 */
class Rooms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%rooms}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedules()
    {
        return $this->hasMany(Schedule::className(), ['room_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return RoomsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RoomsQuery(get_called_class());
    }
}
