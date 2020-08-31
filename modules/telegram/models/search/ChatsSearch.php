<?php


namespace app\modules\telegram\models\search;




use app\models\generated\Chats;

class ChatsSearch
{

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord|null
     */
    public static function searchByTelegramUserId($id)
    {
            $chat = Chats::find()->where(['telegramUserId' => $id])->asArray()->one();
            return $chat;
    }
}