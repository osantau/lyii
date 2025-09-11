<?php

use yii\db\Migration;

class m250911_110428_add_column_status_on_transport_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
  $this->addColumn('{{%transport_order}}','status',$this->smallInteger(1)->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250911_110428_add_column_status_on_transport_order_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250911_110428_add_column_status_on_transport_order_table cannot be reverted.\n";

        return false;
    }
    */
}
