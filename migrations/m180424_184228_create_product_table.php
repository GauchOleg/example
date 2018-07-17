<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product`.
 */
class m180424_184228_create_product_table extends Migration
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

        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->defaultValue(0),
            'name' => $this->string(255),
            'alias' => $this->string(255),
            'code' => $this->string(60),
            'price' => $this->decimal(7,2),
            'text' => $this->text(),
            'seo_title' => $this->string(255),
            'seo_keywords' => $this->string(255),
            'seo_description' => $this->string(255),
            'new' => $this->boolean()->defaultValue(false),
            'sale' => $this->boolean()->defaultValue(false),
            'create_at' => $this->dateTime(),
            'update_at' => $this->dateTime(),
        ],$tableOptions);

        $this->createIndex('idx_cat_id','{{%product}}','category_id');
        $this->addForeignKey('fk_cat_id','{{%product}}','category_id','{{%category}}','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('cat_id','{{%product}}');
        $this->dropForeignKey('category_id','{{%product}}');
        $this->dropTable('{{%product}}');
    }
}
