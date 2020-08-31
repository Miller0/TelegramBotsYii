<?php


namespace app\modules\telegram\models\form;


use app\models\generated\TelegramUser;

class TelegramUserForm extends TelegramUser
{

    /**
     * @return TelegramUser|bool
     */
    public function create()
    {
        $model = new TelegramUser();
        $model->telegramId = $this->telegramId;
        $model->username = $this->username;
        $model->firstName = $this->firstName;
        $model->lastName = $this->lastName;
        $model->type = $this->type;

        if ($model->validate())
            if($model->save())
                return $model;

        return false;

    }

}