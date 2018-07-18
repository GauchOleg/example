<?php

use yii\db\Migration;

/**
 * Class m180718_074357_update_table_cart_field_ordered
 */
class m180718_074357_update_table_cart_field_ordered extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%cart}}','date_ordered',$this->dateTime());
    }

    public function down()
    {
        $this->dropColumn('{{%cart}}', 'date_ordered');
    }

}
