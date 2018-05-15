<?php

use yii\db\Migration;

/**
 * Class m180514_233009_updates
 */
class m180514_233009_updates extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("ALTER TABLE course DROP FOREIGN KEY course_ibfk_1;");
        $this->execute("ALTER TABLE `course` DROP `user_id`;");
        $this->execute("ALTER TABLE `class_room` ADD `user_id` INT NOT NULL AFTER `room_id`;");
        $this->execute("ALTER TABLE `class_room` ADD INDEX(`user_id`);");
        $this->execute("ALTER TABLE `class_room` ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;");
        $this->execute("ALTER TABLE `class_room` ADD `title` TEXT NULL DEFAULT NULL AFTER `id`;");
        $this->execute( "ALTER TABLE schedule DROP FOREIGN KEY schedule_ibfk_3;");
        $this->execute( "ALTER TABLE `schedule` DROP `room_id`;");
        $this->execute( "ALTER TABLE class_room_days DROP FOREIGN KEY class_room_days_ibfk_2;");
        $this->execute( "ALTER TABLE `class_room_days` DROP `course_id`;");
        $this->execute( "ALTER TABLE task DROP FOREIGN KEY task_ibfk_1;");
        $this->execute( "ALTER TABLE `task` CHANGE `course_id` `class_room_id` INT(11) NOT NULL;");
        $this->execute( "ALTER TABLE `task` ADD FOREIGN KEY (`class_room_id`) REFERENCES `class_room`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;");
        $this->execute( "ALTER TABLE `class_room` ADD `start_date` TEXT NULL DEFAULT NULL AFTER `user_id`;");
        $this->execute( "ALTER TABLE `class_room` ADD `end_date` TEXT NULL DEFAULT NULL AFTER `start_date`;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180514_233009_updates cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180514_233009_updates cannot be reverted.\n";

        return false;
    }
    */
}
