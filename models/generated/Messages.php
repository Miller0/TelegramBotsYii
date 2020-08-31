<?php

namespace app\models\generated;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property string $text
 * @property int $chatId
 * @property int $senderId
 * @property string $senderType
 * @property string $create
 * @property string $status
 * @property int|null $deleted
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'senderId', 'senderType'], 'required'],
            [['chatId', 'senderId', 'deleted'], 'integer'],
            [['senderType', 'status'], 'string'],
            [['create'], 'safe'],
            [['text'], 'string', 'max' => 5000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'chatId' => 'Chat ID',
            'senderId' => 'Sender ID',
            'senderType' => 'Sender Type',
            'create' => 'Create',
            'status' => 'Status',
            'deleted' => 'Deleted',
        ];
    }
}
