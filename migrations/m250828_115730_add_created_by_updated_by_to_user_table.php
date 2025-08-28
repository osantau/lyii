<?php

use yii\db\Migration;

class m250828_115730_add_created_by_updated_by_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
           $this->addColumn('{{%user}}', 'created_by', $this->integer());
           $this->addColumn('{{%user}}', 'updated_by', $this->integer());

    // optional: add foreign keys if you want relations
    $this->addForeignKey(
        'fk-user-created_by',
        '{{%user}}',
        'created_by',
        '{{%user}}',
        'id',
        'SET NULL',
        'CASCADE'
    );

    $this->addForeignKey(
        'fk-user-updated_by',
        '{{%user}}',
        'updated_by',
        '{{%user}}',
        'id',
        'SET NULL',
        'CASCADE'
    );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250828_115730_add_created_by_updated_by_to_post_table cannot be reverted.\n";
        $this->dropForeignKey('fk-user-created_by', '{{%user}}');
    $this->dropForeignKey('fk-user-updated_by', '{{%user}}');

    $this->dropColumn('{{%user}}', 'created_by');
    $this->dropColumn('{{%user}}', 'updated_by');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250828_115730_add_created_by_updated_by_to_post_table cannot be reverted.\n";

        return false;
    }
    */
}
