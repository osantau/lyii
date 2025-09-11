<?php

use yii\db\Migration;

class m250911_065730_add_columns_addresses_to_vehicle_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%vehicle}}',"start_date",$this->date()->defaultValue(null));
         $this->addColumn('{{%vehicle}}',"end_date",$this->date()->defaultValue(null));
        $this->addColumn('{{%vehicle}}',"exp_adr_start",$this->string(255)->defaultValue(""));
        $this->addColumn('{{%vehicle}}',"exp_adr_end",$this->string(255)->defaultValue(""));
        $this->addColumn('{{%vehicle}}',"imp_adr_start",$this->string(255)->defaultValue(""));
        $this->addColumn('{{%vehicle}}',"imp_adr_end",$this->string(255)->defaultValue(""));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250911_065730_add_columns_addresses_to_vehicle_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250911_065730_add_columns_addresses_to_vehicle_table cannot be reverted.\n";

        return false;
    }
    */
}
