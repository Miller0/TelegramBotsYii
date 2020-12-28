<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bots}}`.
 */
class m200723_190001_create_bots_table extends Migration
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

        $this->createTable('bots', [
            'id' => $this->primaryKey(),
            'created' => $this->timestamp()->notNull()->append('DEFAULT current_timestamp()'),
            'updated' => $this->timestamp()->notNull()->append('DEFAULT current_timestamp() ON UPDATE current_timestamp()'),

            'userId' => $this->integer(),
            'deleted' => $this->integer(),

            'token' => $this->string(32),
            'status' => $this->string(32),
            'webHookKey' => $this->string(50),

        ], $tableOptions);

        $this->createIndex(
            'webHookKeyToken',
            'bots',
            ['webHookKey', 'token'],
            true
        );


    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropIndex('webHookKeyToken','bots');
        $this->dropTable('bots');
    }
}
