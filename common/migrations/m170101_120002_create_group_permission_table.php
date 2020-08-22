<?php

use yii\db\Migration;

class m170101_120002_create_group_permission_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%group_permission}}', [
            'group_id' => $this->bigInteger(20),
            'permission_id' => $this->bigInteger(20),
        ], $tableOptions);

        $this->createIndex('group_id', '{{%group_permission}}', 'group_id');
        $this->createIndex('permission_id', '{{%group_permission}}', 'permission_id');
    }

    public function safeDown()
    {
        $this->dropTable('{{%group_permission}}');
    }

}
