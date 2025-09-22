<?php

use yii\db\Migration;

class m250922_070747_add_vehicle_address_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->addColumn('{{%vehicle}}',"exp_adr_start_id",$this->integer(11)->defaultValue(0));
         $this->addColumn('{{%vehicle}}',"exp_adr_end_id",$this->integer(11)->defaultValue(0));
         $this->addColumn('{{%vehicle}}',"imp_adr_start_id",$this->integer(11)->defaultValue(0));
         $this->addColumn('{{%vehicle}}',"imp_adr_end_id",$this->integer(11)->defaultValue(0));
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250922_070747_add_vehicle_address_columns cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250922_070747_add_vehicle_address_columns cannot be reverted.\n";

        return false;
    }
    */
}
