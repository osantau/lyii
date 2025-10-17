<?php

use yii\db\Migration;

class m251017_064022_add_paymentterm_on_invoice_and_payment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%payment}}',"paymentterm",$this->integer(11)->defaultValue(null));
        $this->addColumn('{{%invoice}}',"paymentterm",$this->integer(11)->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m251017_064022_add_paymentterm_on_invoice_and_payment cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251017_064022_add_paymentterm_on_invoice_and_payment cannot be reverted.\n";

        return false;
    }
    */
}
