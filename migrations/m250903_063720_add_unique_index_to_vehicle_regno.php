<?php

use yii\db\Migration;

class m250903_063720_add_unique_index_to_vehicle_regno extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Add unique index on `email` column in `user` table
        $this->createIndex(
            'idx-vehicle-regno-unique',
            'vehicle',
            'regno',
            true // <- unique = true
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {       
        $this->dropIndex(
            'idx-vehicle-regno-unique',
            'vehicle'
        );
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250903_063720_add_unique_index_to_vehicle_regno cannot be reverted.\n";

        return false;
    }
    */
}
