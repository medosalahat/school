<?php

use yii\db\Migration;

/**
 * Class m180507_005132_aaddd
 */
class m180507_005132_aaddd extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('ALTER TABLE `course` ADD `image` TEXT NULL DEFAULT NULL AFTER `id`;');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180507_005132_aaddd cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180507_005132_aaddd cannot be reverted.\n";

        return false;
    }
    */
}
