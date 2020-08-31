<?php

namespace app\models\generated;

use Yii;

/**
 * This is the model class for table "errors".
 *
 * @property int $id
 * @property string $created
 * @property int|null $userId
 * @property int|null $code
 * @property string|null $text
 * @property string|null $exception
 */
class Errors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'errors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created'], 'safe'],
            [['userId', 'code'], 'integer'],
            [['text', 'exception'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created' => 'Created',
            'userId' => 'User ID',
            'code' => 'Code',
            'text' => 'Text',
            'exception' => 'Exception',
        ];
    }
}
