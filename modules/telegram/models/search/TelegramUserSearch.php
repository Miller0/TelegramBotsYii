<?php


namespace app\modules\telegram\models\search;


use app\models\generated\TelegramUser;

class TelegramUserSearch
{

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord|null
     */
    public static function searchByTelegramId($id)
    {
            $telegramUser = TelegramUser::find()->where(['telegramId' => $id])->asArray()->one();
            return $telegramUser;
    }

}