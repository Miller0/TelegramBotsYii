<?php


namespace app\modules\telegram\models\form;


use app\models\generated\Chats;

class ChatsForm extends Chats
{

    /**
     * @return Chats|bool
     */
    public function create()
    {
        $model = new Chats();
        $model->botId = $this->botId;
        $model->telegramUserId = $this->telegramUserId;
        $model->name = $this->name;

        if ($model->validate())
            if($model->save())
                return $model;

        return false;

    }


    public static function overwriteUpdateById($id)
    {
        $model = Chats::find()->where(['id' => $id])->one();
        if(empty($model))
            return false;

        $model->update = date('Y-m-d H:i:s');
        return $model->save();
    }


}