<?php

use yii\db\Migration;

class m170101_120003_create_user_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->bigPrimaryKey(20),
            'language_id' => $this->bigInteger(20)->null(),
            'name' => $this->string(255)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string(255)->notNull(),
            'password_reset_token' => $this->string(255)->unique(),
            'email' => $this->string(255)->notNull()->unique(),
            'status' => "ENUM('active', 'inactive')",
            'root' => "ENUM('yes', 'no')",
            'gender' => "ENUM('male', 'female')",
            'avatar_path' => $this->string(255),
            'avatar_base_url' => $this->string(255),
            'timezone' => $this->string(255)->notNull(),
            'logged_at' => $this->integer()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->null(),
        ], $tableOptions);

        $this->createIndex('language_id', '{{%user}}', 'language_id');
        $this->createIndex('status', '{{%user}}', 'status');
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }

}
