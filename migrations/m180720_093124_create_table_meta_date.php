<?php

use yii\db\Migration;

/**
 * Class m180720_093124_create_table_meta_date
 */
class m180720_093124_create_table_meta_date extends Migration
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
        $this->createTable('{{%meta_data}}',[
            'id'            => $this->primaryKey(),
            'meta_key'      => $this->string(255)->unique(),
            'meta_value'    => $this->text(),
        ],$tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%meta_data}}');
    }
}
