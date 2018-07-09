<?php

use yii\db\Migration;

/**
 * Class m180709_180153_add_small_text_product_table
 */
class m180709_180153_add_small_text_product_table extends Migration
{

    public function up()
    {
        $this->addColumn('{{%product}}','small_text',$this->string(255));
    }

    public function down()
    {
        $this->dropColumn('{{%product}}','small_text');
    }
}
