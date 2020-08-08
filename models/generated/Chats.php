<?php

namespace app\models\generated;

use Yii;

/**
 * This is the model class for table "chats".
 *
 * @property int $id
 * @property string $name
 * @property int $botId
 * @property int $telegramUserId
 * @property string $create
 * @property string $update
 * @property int|null $deleted
 */
class Chats extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chats';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'botId'], 'required'],
            [['botId', 'telegramUserId', 'deleted'], 'integer'],
            [['create', 'update'], 'safe'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'botId' => 'Bot ID',
            'telegramUserId' => 'Telegram User ID',
            'create' => 'Create',
            'update' => 'Update',
            'deleted' => 'Deleted',
        ];
    }
}
