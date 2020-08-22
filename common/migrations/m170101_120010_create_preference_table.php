<?php

use yii\db\Migration;

class m170101_120010_create_preference_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%preference}}', [
            'id' => $this->bigPrimaryKey(20),
            'key' => $this->string(255)->notNull(),
            'value' => $this->string(255)->null(),
            'description' => $this->string(255)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->null(),
        ], $tableOptions);

        $this->createIndex('key', '{{%preference}}', 'key');
    }

    public function safeDown()
    {
        $this->dropTable('{{%preference}}');
    }

}
