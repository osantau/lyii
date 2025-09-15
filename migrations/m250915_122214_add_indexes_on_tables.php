<?php

use yii\db\Migration;

class m250915_122214_add_indexes_on_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx_driver_first_name_last_name_email',
            '{{%driver%}}',
            ['first_name', 'last_name','email']            
        );

        $this->createIndex(
            'idx_partner_name',
            '{{%partner%}}',
            'name'
        );

        $this->createIndex(
            'idx_transport_order_documentno',
            '{{%transport_order%}}',
            'documentno'
        );

        $this->createIndex(
            'idx_vehicle_regno',
            '{{%vehicle%}}',
            'regno'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250915_122214_add_indexes_on_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250915_122214_add_indexes_on_tables cannot be reverted.\n";

        return false;
    }
    */
}
