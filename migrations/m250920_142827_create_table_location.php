<?php

use yii\db\Migration;

class m250920_142827_create_table_location extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
           $this->createTable('{{%location}}', [
             'id' => $this->primaryKey(),
             'countries_id' =>$this->integer()->notNull()->defaultValue(0),
             'states_id'=>$this->integer()->notNull()->defaultValue(0),   
             'cities_id'=>$this->integer()->notNull()->defaultValue(0),    
             'partner_id'=>$this->integer(11)->notNull()->defaultValue(0),
             'company'=>$this->string('100')->notNull()->defaultValue(''),
             'country'=>$this->string(100)->notNull()->defaultValue(''),
             'region'=>$this->string(50)->notNull()->defaultValue(''),
             'city'=>$this->string(100)->notNull()->defaultValue(''),       
             'address'=>$this->string(255)->notNull()->defaultValue(''),
             'created_at' => $this->integer()->notNull(),
             'updated_at' => $this->integer()->notNull(),
             'created_by'=>$this->integer(),
             'updated_by'=> $this->integer(),             
        ]);
         $this->addForeignKey(
        'fk-location-created_by',
        '{{%location}}',
        'created_by',
        '{{%user}}',
        'id',
        'SET NULL',
        'NO ACTION'
    );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250920_142827_create_table_address cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250920_142827_create_table_address cannot be reverted.\n";

        return false;
    }
    */
}
