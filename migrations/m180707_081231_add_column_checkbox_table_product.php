<?php

use yii\db\Migration;

/**
 * Class m180707_081231_add_column_checkbox_table_product
 */
class m180707_081231_add_column_checkbox_table_product extends Migration
{
    /**
     * {@inheritdoc}
     */

    public function up()
    {
        $this->addColumn('{{%product}}','checkboxes',$this->string(255));
    }

    public function down()
    {
        $this->dropColumn('{{%product}}','checkboxes');
    }
}
