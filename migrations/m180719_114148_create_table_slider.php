<?php

use yii\db\Migration;

/**
 * Class m180719_114148_create_table_slider
 */
class m180719_114148_create_table_slider extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = null;
        if ('mysql' === $this->db->driverName) {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%slider}}',[
            'id'                => $this->primaryKey(),
            'num_id'            => $this->smallInteger(255),
            'title'             => $this->string(255),
            'pre_description'   => $this->string(255),
            'image'             => $this->string(255),
            'description'       => $this->text(),
            'link'              => $this->string(255),
            'status'            => $this->smallInteger(2)->defaultValue(1),
            'create_at'         => $this->dateTime(),
            'update_at'         => $this->dateTime(),
        ],$tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%slider}}');
    }
}
