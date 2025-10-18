<?php

use yii\db\Migration;

class m251017_181909_modify_documento_transport_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk_vehicle_transport_order','{{%vehicle}}');
        $this->dropTable('{{%transport_order}}');
        $this->createTable('{{%transport_order}}', [
             'id' => $this->primaryKey(),
             'documentno' => $this->string(2000)->defaultValue(null),
             'dateordered'=>$this->date()->defaultValue(null),
             'partner_id' => $this->integer(11)->defaultValue(null),             
             'created_at' => $this->integer(11)->defaultValue(null),
             'updated_at' => $this->integer(11)->defaultValue(null),
             'created_by'=>$this->integer(11)->defaultValue(null),
             'updated_by'=> $this->integer(11)->defaultValue(null),
             
        ]);       
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
