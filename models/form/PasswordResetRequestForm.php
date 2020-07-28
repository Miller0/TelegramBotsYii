<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\app\models\User',
                'filter' => ['deleted' => User::STATUS_NOT_DELETED],
                'message' => 'There is no user with such email.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'deleted' => User::STATUS_NOT_DELETED,
            'email' => $this->email,
        ]);

        if (!$user)
        {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->passwordResetToken))
        {
            $user->generatePasswordResetToken();
            if (!$user->save())
            {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'layouts/passwordResetToken-html', 'text' => 'layouts/passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom('robot@spacebot.pp.ua')
            ->setTo($this->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();

    }


}