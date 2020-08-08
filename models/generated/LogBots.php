<?php

namespace app\models\generated;

use Yii;

/**
 * This is the model class for table "logBots".
 *
 * @property int $id
 * @property string $text
 * @property string $create
 * @property int|null $botId
 */
class LogBots extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'logBots';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['create'], 'safe'],
            [['botId'], 'integer'],
            [['text'], 'string', 'max' => 200],
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
            'create' => 'Create',
            'botId' => 'Bot ID',
        ];
    }
}
