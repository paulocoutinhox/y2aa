<?php

use yii\db\Migration;

class m170101_120001_create_permission_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%permission}}', [
            'id' => $this->bigPrimaryKey(20),
            'action' => $this->string(255)->notNull(),
            'action_group' => $this->string(255)->null(),
            'description' => $this->string(255)->null(),
            'status' => "ENUM('active', 'inactive')",
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->null(),
        ], $tableOptions);

        $this->createIndex('action', '{{%permission}}', 'action');
        $this->createIndex('action_group', '{{%permission}}', 'action_group');
        $this->createIndex('status', '{{%permission}}', 'status');
    }

    public function safeDown()
    {
        $this->dropTable('{{%permission}}');
    }

}
