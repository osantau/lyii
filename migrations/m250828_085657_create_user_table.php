<?php

use yii\db\Migration;
use app\models\User;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m250828_085657_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull()->defaultValue(''),
            'password_hash' => $this->string()->notNull(),
            'auth_key' => $this->string(32),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'is_admin'=>$this->boolean()->notNull()->defaultValue(false),
        ]);
        $admin = new User();
        $admin->username = "admin";
        $admin->email = "admin@example.com";
        $admin->is_admin = 1;
        $admin->password = "admin2025";
        $admin->password_hash = Yii::$app->security->generatePasswordHash('admin2025');
        $admin->created_at = time();
        $admin->updated_at = time();    
        $admin->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
