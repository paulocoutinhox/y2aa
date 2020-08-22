<?php

use yii\db\Migration;

class m170101_120004_create_user_group_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_group}}', [
            'user_id' => $this->bigInteger(20),
            'group_id' => $this->bigInteger(20),
        ], $tableOptions);

        $this->createIndex('user_id', '{{%user_group}}', 'user_id');
        $this->createIndex('group_id', '{{%user_group}}', 'group_id');
    }

    public function safeDown()
    {
        $this->dropTable('{{%user_group}}');
    }

}
