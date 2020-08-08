<?php

namespace app\models\generated;

use Yii;

/**
 * This is the model class for table "bots".
 *
 * @property int $id
 * @property int $userId
 * @property string|null $name
 * @property string $token
 * @property string|null $webHookKey
 * @property string|null $create
 * @property string|null $status
 * @property int|null $deleted
 */
class Bots extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bots';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'token'], 'required'],
            [['userId', 'deleted'], 'integer'],
            [['create'], 'safe'],
            [['status'], 'string'],
            [['name', 'token', 'webHookKey'], 'string', 'max' => 50],
            [['webHookKey', 'token'], 'unique', 'targetAttribute' => ['webHookKey', 'token']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'name' => 'Name',
            'token' => 'Token',
            'webHookKey' => 'Web Hook Key',
            'create' => 'Create',
            'status' => 'Status',
            'deleted' => 'Deleted',
        ];
    }
}
