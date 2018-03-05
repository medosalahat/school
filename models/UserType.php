<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%user_type}}".
 *
 * @property int $id
 * @property string $user_name
 *
 * @property Users[] $users
 */
class UserType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_name' => Yii::t('app', 'User Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['type_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UserTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserTypeQuery(get_called_class());
    }
}
