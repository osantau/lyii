<?php

use yii\db\Migration;

class m250911_100347_add_column_transport_order_id_to_vehicle_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%vehicle}}',"transport_order_id",$this->integer(11)->defaultValue(null));
         $this->addForeignKey(
        'fk_vehicle_transport_order',
        '{{%vehicle}}',
        'transport_order_id',
        '{{%transport_order}}',
        'id'
    );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250911_100347_add_column_transport_order_id_to_vehicle_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250911_100347_add_column_transport_order_id_to_vehicle_table cannot be reverted.\n";

        return false;
    }
    */
}
