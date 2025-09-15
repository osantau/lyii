<?php

use yii\db\Migration;

class m250909_094752_create_Table_partner extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%partner}}', [
             'id' => $this->primaryKey(),
             'name' => $this->string(100)->notNull(),             
             'created_at' => $this->integer()->notNull(),
             'updated_at' => $this->integer()->notNull(),
             'created_by'=>$this->integer(),
             'updated_by'=> $this->integer(),
             
        ]);
    
     $this->addForeignKey(
        'fk_partner_created_by',
        '{{%partner}}',
        'created_by',
        '{{%user}}',
        'id',
        'SET NULL',
        'NO ACTION'
    );

    $this->addForeignKey(
        'fk_partner_updated_by',
        '{{%partner}}',
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
        echo "m250909_094752_create_Table_partner cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250909_094752_create_Table_partner cannot be reverted.\n";

        return false;
    }
    */
}
