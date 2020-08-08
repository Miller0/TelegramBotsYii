<?php

namespace app\models\generated;

use Yii;

/**
 * This is the model class for table "logTelegramWebHook".
 *
 * @property int $id
 * @property string|null $text
 * @property string|null $create
 */
class LogTelegramWebHook extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'logTelegramWebHook';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create'], 'safe'],
            [['text'], 'string', 'max' => 500],
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
        ];
    }
}
