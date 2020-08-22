<?php

use yii\db\Migration;

class m170101_120009_create_gallery_item_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%gallery_item}}', [
            'id' => $this->bigPrimaryKey(20),
            'gallery_id' => $this->bigInteger(20)->notNull(),
            'path' => $this->string(255)->notNull(),
            'base_url' => $this->string(255),
            'type' => $this->string(255),
            'size' => $this->integer(),
            'name' => $this->string(255),
            'order' => $this->integer(),
            'created_at' => $this->integer()
        ], $tableOptions);

        $this->createIndex('gallery_id', '{{%gallery_item}}', 'gallery_id');
        $this->createIndex('order', '{{%gallery_item}}', 'order');
    }

    public function safeDown()
    {
        $this->dropTable('{{%gallery_item}}');
    }

}
