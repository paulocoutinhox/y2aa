<?php

use yii\db\Migration;

class m170101_120007_create_content_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%content}}', [
            'id' => $this->bigPrimaryKey(20),
            'title' => $this->string(255)->notNull(),
            'tag' => $this->string(255)->null(),
            'content' => $this->text(),
            'language_id' => $this->bigInteger(20)->null(),
            'status' => "ENUM('active', 'inactive')",
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->null(),
        ], $tableOptions);

        $this->createIndex('title', '{{%content}}', 'title');
        $this->createIndex('tag', '{{%content}}', 'tag');
        $this->createIndex('language_id', '{{%content}}', 'language_id');
        $this->createIndex('status', '{{%content}}', 'status');
        $this->createIndex('created_at', '{{%content}}', 'created_at');
    }

    public function safeDown()
    {
        $this->dropTable('{{%content}}');
    }

}
