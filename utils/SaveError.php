<?php

namespace app\utils;

use app\models\generated\Errors;
use Yii;

class SaveError
{

    const ERROR_CODES =
        [
            1 => 'unknown error',
            100 => 'logBotsForm',
            101 => 'logBotsForm',
            1000 => 'BotsForm',
            1001 => 'BotModel',
            1002 => 'WebHook',
            1003 => 'MessagesModel',
        ];


    public static function save($code = 1, $exception = '', $text = '')
    {
        try
        {

            if (empty($code))
                return false;

            if (!isset($codes[$code]))
                $code = 1;

            $error = new Errors();
            $error->code = $code;
            $error->userId = Yii::$app->user->getId() ?? 0;
            $error->text = self::ERROR_CODES[$code].'. '.$text;
            $error->exception = $exception;

            if($error->save())
               return true;

            $error = new Errors();
            $error->code = $code;
            $error->save();

        }
        catch (\Exception $e)
        {
        }

        return false;
    }


}