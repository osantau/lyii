<?php

use yii\db\Migration;

class m251018_050508_add_paid_status_invoice_payment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->addColumn('{{%payment}}',"paid_status",$this->integer(11)->defaultValue(null));
        $this->addColumn('{{%invoice}}',"paid_status",$this->integer(11)->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m251018_050508_add_paid_status_invoice_payment cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251018_050508_add_paid_status_invoice_payment cannot be reverted.\n";

        return false;
    }
    */
}
