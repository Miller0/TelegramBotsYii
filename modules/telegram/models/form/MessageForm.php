<?php


namespace app\modules\telegram\models\form;


use app\models\generated\Messages;

class MessageForm extends Messages
{

    /**
     * @return Messages|bool
     */
    public function create()
    {
        $model = new Messages();
        $model->text = $this->text;
        $model->chatId = $this->chatId;
        $model->senderId = $this->senderId;
        $model->senderType = $this->senderType;
        $model->status = $this->status;

        if ($model->validate())
            if($model->save())
                return $model;

        return false;

    }

}