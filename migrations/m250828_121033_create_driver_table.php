<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%driver}}`.
 */
class m250828_121033_create_driver_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%driver}}', [
            'id' => $this->primaryKey(),
             'first_name' => $this->string()->notNull(),
             'last_name' => $this->string()->notNull(),
             'email' => $this->string(),
             'phone' => $this->string(50),
             'address' => $this->string(),
             'created_at' => $this->integer()->notNull(),
             'updated_at' => $this->integer()->notNull(),
             'created_by'=>$this->integer(),
             'updated_by'=> $this->integer(),
             
        ]);
    
     $this->addForeignKey(
        'fk-driver-created_by',
        '{{%driver}}',
        'created_by',
        '{{%user}}',
        'id',
        'SET NULL',
        'NO ACTION'
    );

    $this->addForeignKey(
        'fk-driver-updated_by',
        '{{%driver}}',
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
        $this->dropTable('{{%driver}}');
    }
}
