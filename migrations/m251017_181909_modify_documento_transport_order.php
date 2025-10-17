<?php

use yii\db\Migration;

class m251017_181909_modify_documento_transport_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%transport_order}}',"documentno",'varchar(4000) default null');
        $this->alterColumn('{{%transport_order}}',"dateordered",'date default null');
        $this->dropIndex('idx_unique_documento_dateordered_partner_id','{{%transport_order}}');
        $this->dropIndex('idx_partner_id','{{%transport_order}}');        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m251017_181909_modify_documento_transport_order cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251017_181909_modify_documento_transport_order cannot be reverted.\n";

        return false;
    }
    */
}
