<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\User;


class SignupForm extends Model
{

    public $username;
    public $email;
    public $password;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * @return User|bool
     */
    public function signup()
    {

        if (!$this->validate())
            return false;

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        if ($user->save())
        {
            try
            {
                $auth = Yii::$app->authManager;
                $role = $auth->getRole('user');
                $auth->assign($role, $user->id);
            }
            catch (\Exception $e)
            {
            }

            return $user;
        }

        return false;

    }

}