<?php


namespace app\modules\telegram\controllers;


use app\models\generated\Bots;
use app\models\generated\Chats;
use app\modules\telegram\models\form\BotsForm;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class CabinetController extends Controller
{

    public $layout = 'cabinet';


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['user'],
                    ],
                ],
            ],
        ];
    }


    public function actionAddBot()
    {

        $model = new BotsForm();

        if ($model->load(Yii::$app->request->post()) )
        {
            if($model->create())
                $this->redirect(['cabinet/index']);
            else
                $error = true;

            $model = new BotsForm();
        }

        return $this->render('addBot',
            [
                'model' => $model,
                'error' => $error,

            ]);
    }

    public function actionDeletedBot($id)
    {
        $modelBot = Bots::findOne(['id' => $id]);
        $modelBot->deleted = 1 ;
        $modelBot->save();

        $modelChat = Chats::find()->select(['id'])->where(['botId'=>$id])->asArray()->all();

        foreach ($modelChat as $id)
        {
            $modelChat = Chats::findOne(['id'=>$id]);
            $modelChat->deleted = 1 ;
            $modelChat->save();

        }

        return 'ok';

    }


}