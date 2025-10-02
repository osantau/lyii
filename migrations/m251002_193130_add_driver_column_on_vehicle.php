<?php

use yii\db\Migration;

class m251002_193130_add_driver_column_on_vehicle extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
            $this->addColumn('{{%vehicle}}',"driver",$this->string(255)->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m251002_193130_add_driver_column_on_vehicle cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251002_193130_add_driver_column_on_vehicle cannot be reverted.\n";

        return false;
    }
    */
}
