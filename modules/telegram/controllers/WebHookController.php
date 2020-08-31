<?php

namespace app\modules\telegram\controllers;

use app\models\generated\Bots;
use app\modules\telegram\models\BotModel;
use app\modules\telegram\models\form\LogBotsForm;
use app\utils\SaveError;
use Throwable;
use Yii;
use yii\web\Controller;

class WebHookController extends Controller
{


    public function beforeAction($action)
    {
        // Off Cross-site request forgery (CSRF)
        $this->enableCsrfValidation = false;
        return parent:: beforeAction($action);
    }

    public function actionIndex()
    {
        try
        {
            $key = Yii::$app->request->get('key');
            if(strlen($key) != 31)
                return false;

            if ($modelBots = Bots::find()->select(['id','name'])->where(['webHookKey' => $key, 'deleted' => 0])->asArray()->one())
            {
                $modelBot = new BotModel($modelBots['id'],true);
                if (!$modelBot->saveMessage())
                {
                    new LogBotsForm('error save message', $modelBots['id']);
                }
            }
            else
                $model = new LogBotsForm( 'error webHook key', $modelBots['id']);


        }
        catch (Throwable   $e)
        {
            SaveError::save(1002, $e->getMessage());
        }

        return 'ok';

    }


}


