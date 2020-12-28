<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%chats}}`.
 */
class m200723_190002_create_chats_table extends Migration
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

        $this->createTable('chats', [
            'id' => $this->primaryKey(),
            'created' => $this->timestamp()->notNull()->append('DEFAULT current_timestamp()'),
            'updated' => $this->timestamp()->notNull()->append('DEFAULT current_timestamp() ON UPDATE current_timestamp()'),

            'botId' => $this->integer(),
            'telegramUserId' => $this->integer(),
            'deleted' => $this->integer(),

            'name' => $this->string(50),

        ], $tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('chats');
    }
}
