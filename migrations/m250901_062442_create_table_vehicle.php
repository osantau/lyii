<?php

use yii\db\Migration;

class m250901_062442_create_table_vehicle extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->createTable('{{%vehicle}}', [
             'id' => $this->primaryKey(),
             'regno' => $this->string(50)->notNull(),             
             'created_at' => $this->integer()->notNull(),
             'updated_at' => $this->integer()->notNull(),
             'created_by'=>$this->integer(),
             'updated_by'=> $this->integer(),
             
        ]);
    
     $this->addForeignKey(
        'fk-vehicle-created_by',
        '{{%vehicle}}',
        'created_by',
        '{{%user}}',
        'id',
        'SET NULL',
        'NO ACTION'
    );

    $this->addForeignKey(
        'fk-vehicle-updated_by',
        '{{%vehicle}}',
        'updated_by',
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
        echo "m250901_062442_create_table_vehicle cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250901_062442_create_table_vehicle cannot be reverted.\n";

        return false;
    }
    */
}
