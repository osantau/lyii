<?php

use yii\db\Migration;

class m251013_160106_add_table_invoice extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->createTable('{{%invoice}}', [
            'id' => $this->primaryKey(),
            'dateinvoiced'=>$this->date()->notNull(),
            'duedate'=>$this->date()->notNull(),
            'duedays'=>$this->integer()->notNull()->defaultValue(0),
            'paymentdate'=>$this->date()->defaultValue(null),
            'nr_factura'=>$this->string(50)->notNull(),
            'partener'=>$this->string(100)->notNull(),            
            'valoare_ron'=>$this->decimal(10,2)->defaultValue(0.00),
            'suma_achitata_ron'=>$this->decimal(10,2)->defaultValue(0.00),
            'sold_ron'=>$this->decimal(10,2)->defaultValue(0.00),
            'valoare_eur'=>$this->decimal(10,2)->defaultValue(0.00),
            'suma_achitata_eur'=>$this->decimal(10,2)->defaultValue(0.00),
            'sold_eur'=>$this->decimal(10,2)->defaultValue(0.00),
            'diferenta'=>$this->decimal(10,2)->defaultValue(0.00),
            'moneda'=>$this->char(3)->notNull()->defaultValue(''),
            'is_customer'=>$this->char(1)->notNull()->defaultValue('Y'),
            'mentiuni'=>$this->string(4000),  
            'credit_note'=>$this->string(4000),  
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by'=>$this->integer(),
            'updated_by'=> $this->integer(),
         ]);
           $this->addForeignKey(
        'fk-invoice-created_by',
        '{{%invoice}}',
        'created_by',
        '{{%user}}',
        'id',
        'SET NULL',
        'NO ACTION'
    );

    $this->addForeignKey(
        'fk-invoice-updated_by',
        '{{%invoice}}',
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
        echo "m251013_160106_add_table_invoice cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251013_160106_add_table_invoice cannot be reverted.\n";

        return false;
    }
    */
}
