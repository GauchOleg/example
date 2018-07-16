<?php

use yii\db\Migration;

/**
 * Class m180716_110824_update_cart_table
 */
class m180716_110824_update_cart_table extends Migration
{
    
    public function up()
    {
        $this->addColumn('{{%cart}}','customer_l_name',$this->string(255));
        $this->addColumn('{{%cart}}','customer_o_name' , $this->string(255));
        $this->addColumn('{{%cart}}','product_code' , $this->string(255));
        $this->addColumn('{{%cart}}','address' , $this->string(255));
        $this->addColumn('{{%cart}}','product_id' , $this->smallInteger(2));
        $this->addColumn('{{%cart}}','count' , $this->smallInteger(2));
        $this->addColumn('{{%cart}}','delivery' , $this->smallInteger(2));
        $this->addColumn('{{%cart}}','prices' , $this->smallInteger(2));
        $this->addColumn('{{%cart}}','total_price' , $this->integer());
    }

    public function down()
    {
        $this->dropColumn('{{%cart}}','customer_l_name');
        $this->dropColumn('{{%cart}}','customer_o_name');
        $this->dropColumn('{{%cart}}','product_code');
        $this->dropColumn('{{%cart}}','address');
        $this->dropColumn('{{%cart}}','product_id');
        $this->dropColumn('{{%cart}}','count');
        $this->dropColumn('{{%cart}}','delivery');
        $this->dropColumn('{{%cart}}','prices');
        $this->dropColumn('{{%cart}}','total_price');
    }

}
