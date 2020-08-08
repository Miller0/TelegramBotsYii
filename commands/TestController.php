<?php


namespace app\commands;




use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use yii\console\Controller;

class TestController extends Controller
{

public function actionTest()
{
    $telegram = new Telegram('1178137066:AAFoghTqNgwd1RdBCmA7k8H6ZpeB4L9T8gg', '1');
                $result = Request::sendMessage([
                'chat_id' => -1001289632263,
                'text'    => '1',
            ]);
                return true;
}


}