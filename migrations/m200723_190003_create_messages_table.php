<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%messages}}`.
 */
class m200723_190003_create_messages_table extends Migration
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

        $this->createTable('messages', [
            'id' => $this->primaryKey(),
            'created' => $this->timestamp()->notNull()->append('DEFAULT current_timestamp()'),
            'updated' => $this->timestamp()->notNull()->append('DEFAULT current_timestamp() ON UPDATE current_timestamp()'),

            'chatId' => $this->integer(),
            'senderId' => $this->integer(),
            'deleted' => $this->integer(),

            'senderType' => $this->string(32),
            'status' => $this->string(32),
            'text' => $this->string(5000),

        ], $tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('messages');
    }
}
