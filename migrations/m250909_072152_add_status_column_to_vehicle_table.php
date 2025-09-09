<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%vehicle}}`.
 */
class m250909_072152_add_status_column_to_vehicle_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%vehicle}}','status',$this->smallInteger(1)->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         $this->dropColumn('{{%post}}', 'status');
    }
}
