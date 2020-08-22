<?php

use yii\db\Migration;

class m170101_120006_create_language_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%language}}', [
            'id' => $this->bigPrimaryKey(20),
            'name' => $this->string(50)->notNull(),
            'native_name' => $this->string(50)->notNull(),
            'code_iso_639_1' => $this->string(50)->notNull(),
            'code_iso_language' => $this->string(50)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->null(),
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%language}}');
    }

}
