<?php

use yii\db\Migration;

class m170101_120005_create_customer_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%customer}}', [
            'id' => $this->bigPrimaryKey(20),
            'language_id' => $this->bigInteger(20)->notNull(),
            'name' => $this->string(255)->notNull(),
            'cpf' => $this->string(11)->notNull(),
            'mobile_phone' => $this->string(11)->notNull(),
            'home_phone' => $this->string(11)->null(),
            'email' => $this->string(255)->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string(255)->notNull(),
            'password_reset_token' => $this->string(255)->unique(),
            'verification_token' => $this->string(255)->unique(),
            'status' => "ENUM('active', 'inactive', 'deleted')",
            'gender' => "ENUM('male', 'female')",
            'avatar_path' => $this->string(255),
            'avatar_base_url' => $this->string(255),
            'obs' => $this->text()->null(),
            'timezone' => $this->string(255)->notNull(),
            'logged_at' => $this->integer()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->null(),
        ], $tableOptions);

        $this->createIndex('language_id', '{{%customer}}', 'language_id');
        $this->createIndex('name', '{{%customer}}', 'name');
        $this->createIndex('cpf', '{{%customer}}', 'cpf');
        $this->createIndex('mobile_phone', '{{%customer}}', 'mobile_phone');
        $this->createIndex('home_phone', '{{%customer}}', 'home_phone');
        $this->createIndex('status', '{{%customer}}', 'status');
        $this->createIndex('gender', '{{%customer}}', 'gender');
    }

    public function safeDown()
    {
        $this->dropTable('{{%customer}}');
    }

}
