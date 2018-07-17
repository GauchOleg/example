<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m180422_134131_create_category_table extends Migration
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

        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->smallInteger()->defaultValue(0),
            'name' => $this->string(100)->notNull(),
            'alias' => $this->string(120)->notNull(),
            'image' => $this->string(255),
            'text' => $this->text(),
            'seo_title' => $this->string(100),
            'seo_keywords' => $this->string(255),
            'seo_description' => $this->string(255),
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%category}}');
    }
}
