<?php

use yii\db\Migration;

class m170101_120000_create_group_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%group}}', [
            'id' => $this->bigPrimaryKey(20),
            'name' => $this->string(255)->notNull(),
            'status' => "ENUM('active', 'inactive')",
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->null(),
        ], $tableOptions);

        $this->createIndex('status', '{{%group}}', 'status');
    }

    public function safeDown()
    {
        $this->dropTable('{{%group}}');
    }

}
