<?php

use yii\db\Migration;

/**
 * Class m180426_171034_create_table_product_img
 */
class m180426_171034_create_table_product_img extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('{{%product_img}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'alias' => $this->string(255),
            'sort_id' => $this->integer()->defaultValue(1)
        ]);

        $this->createIndex('idx_prod_id','{{%product_img}}','product_id');
        $this->addForeignKey('fk_prod_id','{{%product_img}}','product_id','{{%product}}','id');
    }

    public function down()
    {
        $this->dropIndex('idx_prod_id','{{%product_img}}');
        $this->dropForeignKey('fk_prod_id','{{%product_img}}');
        $this->dropTable('{{%product}}');
    }
}

