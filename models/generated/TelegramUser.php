<?php

namespace app\models\generated;

use Yii;

/**
 * This is the model class for table "telegramUser".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $firstName
 * @property string|null $lastName
 * @property int $telegramId
 * @property string|null $type
 * @property string|null $create
 */
class TelegramUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegramUser';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['telegramId'], 'integer'],
            [['type'], 'string'],
            [['create'], 'safe'],
            [['username', 'firstName', 'lastName'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'telegramId' => 'Telegram ID',
            'type' => 'Type',
            'create' => 'Create',
        ];
    }
}
