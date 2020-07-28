<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%log_authorizations}}`.
 */
class m200723_171941_create_log_authorizations_table extends Migration
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

        $this->createTable('logAuthorizations', [
            'id' => $this->primaryKey(),
            'userId' => $this->integer()->notNull(),
            'email' => $this->string()->notNull(),
            'ip' => $this->string()->notNull(),
            'created' => $this->timestamp()->notNull()->append('DEFAULT current_timestamp()'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('logAuthorizations');
    }
}
