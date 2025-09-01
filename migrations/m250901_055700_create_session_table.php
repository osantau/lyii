<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%session}}`.
 */
class m250901_055700_create_session_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->execute("create table session( 
                id char(40) not null primary key,
                expire integer,
                data BLOB);");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%session}}');
    }
}
