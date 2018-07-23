<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_meta`.
 */
class m180723_184656_create_user_meta_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ('mysql' === $this->db->driverName) {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        if (null === Yii::$app->db->getSchema()->getTableSchema('{{%user_meta}}')) {
            $this->createTable('{{%user_meta}}', [
                'id'                => $this->primaryKey(),
                'user_id'           => $this->integer()->notNull(),
                'meta_key'          => $this->string()->notNull(),
                'meta_value'        => $this->text()->notNull(),
            ], $tableOptions);

            // Add user foreign key
            $this->addForeignKey('fk_user_meta', '{{%user_meta}}', 'user_id', '{{%users}}', 'id', 'CASCADE', 'RESTRICT');

            // Add indexes
            $this->createIndex('inx_meta_key', '{{%user_meta}}', 'meta_key');
            $this->createIndex('inx_user_meta_key', '{{%user_meta}}', ['user_id', 'meta_key']);
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        if (null !== Yii::$app->db->getSchema()->getTableSchema('{{%user_meta}}')) {
            $this->dropTable('{{%user_meta}}');
        }
    }
}
