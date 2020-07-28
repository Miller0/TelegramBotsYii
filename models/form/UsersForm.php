<?php

namespace app\models\form;

use app\models\generated\Users;
use app\models\User;


class UsersForm extends Users
{

    public $id ;


    public function rules()
    {
        return [
            [['id'], 'integer'],
        ];
    }


    /**
     * @return bool
     */
    public function deleteById()
    {
        if(!$this->validate())
            return false;

        if($user = Users::findOne(['id' => $this->id,'deleted' => User::STATUS_NOT_DELETED]))
        {
            $user->deleted = 1;
            if ($user->save())
                return true;
        }

        return false;

    }

}