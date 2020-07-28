<?php

namespace app\models;

use app\models\generated\Users;
use yii;
use yii\base\NotSupportedException;

/**
 * Class User
 * @package app\models
 */
class User extends Users implements \yii\web\IdentityInterface
{

    const STATUS_NOT_DELETED = 0;


    public static function findIdentity($id)
    {
        return User::findOne(['id' => $id, 'deleted' => self::STATUS_NOT_DELETED]);
    }


    public static function findIdentityByAccessToken($token, $type = null)
    {
       return false;
    }

    public static function findByUsername($username)
    {
        return User::findOne(['username' => $username, 'deleted' => self::STATUS_NOT_DELETED]);

    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'deleted' => self::STATUS_NOT_DELETED]);
    }


    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->passwordHash);
    }


    public function setPassword($password)
    {
        $this->passwordHash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }

    public static function findByPasswordResetToken($token)
    {

        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'passwordResetToken' => $token,
            'deleted' => self::STATUS_NOT_DELETED,
        ]);
    }

    public static function isPasswordResetTokenValid($token)
    {

        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function generatePasswordResetToken()
    {
        $this->passwordResetToken = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken()
    {
        $this->passwordResetToken = null;
    }
}
