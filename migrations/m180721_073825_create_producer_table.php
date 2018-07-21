<?php

use yii\db\Migration;

/**
 * Handles the creation of table `producer`.
 */
class m180721_073825_create_producer_table extends Migration
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

        $this->createTable('{{%producer}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'image' => $this->string(255),
            'description' => $this->text(),
            'active' => $this->boolean(),
            'seo_title' => $this->string(255),
            'seo_keywords' => $this->string(255),
            'seo_description' => $this->string(255),
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%producer}}');
    }
}
