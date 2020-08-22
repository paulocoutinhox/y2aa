<?php

use yii\db\Migration;

class m170101_120011_create_log_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%log}}', [
            'id' => $this->bigPrimaryKey(20),
            'customer_id' => $this->bigInteger(20)->null(),
            'source' => $this->string(255)->notNull(),
            'level' => $this->integer()->notNull(),
            'description' => $this->text()->null(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('customer_id', '{{%log}}', 'customer_id');
        $this->createIndex('source', '{{%log}}', 'source');
        $this->createIndex('level', '{{%log}}', 'level');
        $this->createIndex('created_at', '{{%log}}', 'created_at');
    }

    public function safeDown()
    {
        $this->dropTable('{{%log}}');
    }

}
