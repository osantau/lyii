<?php

use yii\db\Migration;

class m251006_104834_add_table_payments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
  $this->createTable('{{%payment}}', [
             'id' => $this->primaryKey(),
             'is_receipt'=>$this->char(1)->notNull()->defaultValue('N'),
             'dateinvoiced'=>$this->date()->notNull(),
             'duedate'=>$this->date()->notNull(),
             'duedays'=>$this->integer()->notNull()->defaultValue(0),
             'nr_cmd_trs'=>$this->string(50)->notNull(),
             'nr_factura'=>$this->string(50)->notNull(),
             'partener'=>$this->string(100)->notNull(),
             'valoare_ron'=>$this->decimal(10,2)->defaultValue(0.00),
             'suma_achitata_ron'=>$this->decimal(10,2)->defaultValue(0.00),
             'sold_ron'=>$this->decimal(10,2)->defaultValue(0.00),
             'valoare_eur'=>$this->decimal(10,2)->defaultValue(0.00),
             'suma_achitata_eur'=>$this->decimal(10,2)->defaultValue(0.00),
             'sold_eur'=>$this->decimal(10,2)->defaultValue(0.00),
             'ron'=>$this->string(3)->defaultValue('RON'),
             'eur'=>$this->string(3)->defaultValue('EUR'),
             'paymentdate'=>$this->date()->defaultValue(null),
             'bank'=>$this->string(100)->defaultValue(''),
             'mentiuni'=>$this->text(),
             'created_at' => $this->integer()->notNull(),
             'updated_at' => $this->integer()->notNull(),
             'created_by'=>$this->integer(),
             'updated_by'=> $this->integer(),
             
        ]);
    $this->addCheck('chk_receipt', '{{%payment}}',"is_receipt IN ('Y','N')");
     $this->addForeignKey(
        'fk-payment-created_by',
        '{{%payment}}',
        'created_by',
        '{{%user}}',
        'id',
        'SET NULL',
        'NO ACTION'
    );

    $this->addForeignKey(
        'fk-payment-updated_by',
        '{{%payment}}',
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
        echo "m251006_104834_add_table_payments cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251006_104834_add_table_payments cannot be reverted.\n";

        return false;
    }
    */
}
