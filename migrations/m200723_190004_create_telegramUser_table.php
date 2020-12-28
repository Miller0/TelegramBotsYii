<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%telegramUser}}`.
 */
class m200723_190004_create_telegramUser_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('telegramUser', [
            'id' => $this->primaryKey(),
            'created' => $this->timestamp()->notNull()->append('DEFAULT current_timestamp()'),
            'updated' => $this->timestamp()->notNull()->append('DEFAULT current_timestamp() ON UPDATE current_timestamp()'),

            'telegramId' => $this->integer(),

            'type' => $this->string(32),
            'username' => $this->string(50),
            'firstName' => $this->string(50),
            'lastName' => $this->string(50),

        ], $tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('telegramUser');
    }
}
