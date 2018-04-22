<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ClassRoom]].
 *
 * @see ClassRoom
 */
class ClassRoomQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return ClassRoom[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ClassRoom|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
