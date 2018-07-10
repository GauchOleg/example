<?php

use yii\db\Migration;

/**
 * Handles the creation of table `checkbox`.
 */
class m180705_112146_create_checkbox_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ('mysql' === $this->db->driverName) {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%checkbox}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100),
            'category_id' => $this->integer(),
            'active' => $this->boolean()->defaultValue(true),
        ],$tableOptions);

        $this->createIndex('idx_cat_id','{{%checkbox}}','category_id');
        $this->addForeignKey('fk_category_id','{{%checkbox}}','category_id','{{%category}}','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx_cat_id','{{%checkbox}}');
        $this->dropForeignKey('fk_category_id','{{%checkbox}}');
        $this->dropTable('{{%checkbox}}');
    }
}
