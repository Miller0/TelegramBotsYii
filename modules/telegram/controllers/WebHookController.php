<?php

namespace app\modules\telegram\controllers;

use app\models\generated\Bots;
use app\models\generated\LogTelegramWebHook;
use app\modules\telegram\models\BotModel;
use app\modules\telegram\models\form\BotsForm;
use app\modules\telegram\models\form\LogBotsForm;
use app\modules\telegram\models\MessadesModel;
use app\utils\SaveError;
use ArithmeticError;
use Error;
use Exception;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Throwable;
use Yii;
use yii\web\Controller;

class WebHookController extends Controller
{


    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;


        return parent:: beforeAction($action);
    }

    public function actionIndex()
    {

        try
        {
            $key = Yii::$app->request->get('key');

            if ($modelBots = Bots::find()->select(['id','name'])->where(['webHookKey' => $key, 'deleted' => 0])->asArray()->one())
            {
                $modelBot = new BotModel($modelBots['id']);

                if (!$modelBot->message->create())
                {
                    new LogBotsForm('error save message', $modelBots['id']);
                }

               if($modelBots['name'] == 'roma')
               {
                   $text = intval($modelBot->message->text);
                   $text++;
                   $result = Request::sendMessage([
                       'chat_id' => -1001289632263,
                       'text'    =>$text,
                   ]);
               }


            }
            else
            {
                $model = new LogTelegramWebHook();
                $model->text = 'error webHook key';
                $model->save();

            }

        }
        catch (Throwable   $e)
        {
            SaveError::save(1002, $e->getMessage());
        }



        return 'ok';


    }


}


