<?php

use yii\db\Migration;

class m251014_060015_add_partner_id_column_to_invoice extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%invoice}}',"partner_id",$this->integer(11)->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m251014_060015_add_partner_id_column_to_invoice cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251014_060015_add_partner_id_column_to_invoice cannot be reverted.\n";

        return false;
    }
    */
}
