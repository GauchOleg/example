<?php

use yii\db\Migration;

/**
 * Class m180712_122557_create_table_cart
 */
class m180712_122557_create_table_cart extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%cart}}',[
            'id'                => $this->primaryKey(),
            'order_id'          => $this->string(255),
            'product_info'      => $this->string(255),
            'customer_name'     => $this->string(255),
            'customer_phone'    => $this->string(255),
            'customer_email'    => $this->string(255),
            'status'            => $this->smallInteger(2)->defaultValue(1),
            'session_id'        => $this->string(255),
            'finished'          => $this->boolean(),
            'create_at'         => $this->dateTime(),
            'update_at'         => $this->dateTime(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%cart}}');
    }
}
