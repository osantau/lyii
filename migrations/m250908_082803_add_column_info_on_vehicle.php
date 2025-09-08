<?php

use yii\db\Migration;

class m250908_082803_add_column_info_on_vehicle extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%vehicle}}',"info",$this->string(100)->defaultValue(""));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250908_082803_add_column_info_on_vehicle cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250908_082803_add_column_info_on_vehicle cannot be reverted.\n";

        return false;
    }
    */
}
