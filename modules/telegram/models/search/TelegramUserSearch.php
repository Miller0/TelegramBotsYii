<?php


namespace app\modules\telegram\models\search;


use app\models\generated\TelegramUser;
use yii\base\Model;

class TelegramUserSearch extends Model
{


    public static function searchById($telegramId)
    {
        if($telegramId)
        {
            $telegramUser = TelegramUser::find()->where(['telegramId' => $telegramId])->asArray()->one();

            return $telegramUser;
        }

        return [] ;

    }

}