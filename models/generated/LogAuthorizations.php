<?php

namespace app\models\generated;

use Yii;

/**
 * This is the model class for table "logAuthorizations".
 *
 * @property int $id
 * @property int $userId
 * @property string $email
 * @property string $ip
 * @property string $created
 */
class LogAuthorizations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'logAuthorizations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'email', 'ip'], 'required'],
            [['userId'], 'integer'],
            [['created'], 'safe'],
            [['email', 'ip'], 'string', 'max' => 255],
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
            'email' => 'Email',
            'ip' => 'Ip',
            'created' => 'Created',
        ];
    }
}
