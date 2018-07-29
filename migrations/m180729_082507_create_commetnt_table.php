<?php

use yii\db\Migration;

/**
 * Handles the creation of table `commetnt`.
 */
class m180729_082507_create_commetnt_table extends Migration
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
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'username' => $this->string(255),
            'product_id' => $this->integer(),
            'text' => $this->text(),
            'active' => $this->boolean()->defaultValue(false),
            'create_at' => $this->dateTime(),
            'update_at' => $this->dateTime(),
        ],$tableOptions);
        $this->addForeignKey('fk_comment_user_id', '{{%comment}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_comment_product_id', '{{%comment}}', 'product_id', '{{%product}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%comment}}');
    }
}
