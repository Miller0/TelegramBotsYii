<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%error}}`.
 */
class m200723_192125_create_error_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql')
        {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('errors', [
            'id' => $this->primaryKey(),
            'created' => $this->timestamp()->notNull()->append('DEFAULT current_timestamp()'),
            'userId' => $this->integer(),
            'code' => $this->integer(),
            'text' => $this->string(32),
            'exception' => $this->string(32),

        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('errors');
    }
}
