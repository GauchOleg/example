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
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%category}}');
    }
}
