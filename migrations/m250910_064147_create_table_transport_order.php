<?php

use yii\db\Migration;

class m250910_064147_create_table_transport_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->createTable('{{%transport_order}}', [
             'id' => $this->primaryKey(),
             'documentno' => $this->string(100)->notNull(),
             'dateordered'=>$this->date()->notNull(),
             'partner_id' => $this->integer(),             
             'created_at' => $this->integer()->notNull(),
             'updated_at' => $this->integer()->notNull(),
             'created_by'=>$this->integer(),
             'updated_by'=> $this->integer(),
             
        ]);

           $this->createIndex(
            'idx_partner_id',
            '{{%transport_order}}',
            'partner_id'
        );
        
    $this->addForeignKey(
        'fk_transport_order_partner',
        '{{%transport_order}}',
        'partner_id',
        '{{%partner}}',
        'id',
        'SET NULL',
        'NO ACTION'
    );
         $this->addForeignKey(
        'fk_transport_order_created_by',
        '{{%transport_order}}',
        'created_by',
        '{{%user}}',
        'id',
        'SET NULL',
        'NO ACTION'
    );

      $this->addForeignKey(
        'fk_transport_order_updated_by',
        '{{%transport_order}}',
        'updated_by',
        '{{%user}}',
        'id',
        'SET NULL',
        'NO ACTION'
    ); 

    $this->createIndex(
    'idx_unique_documento_dateordered_partner_id', // index name
    '{{%transport_order}}',                          // table name
    ['documentno', 'dateordered', 'partner_id'],    // columns
    true                                     // unique = true
);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250910_064147_create_table_transport_order cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250910_064147_create_table_transport_order cannot be reverted.\n";

        return false;
    }
    */
}
