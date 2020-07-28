<?php

namespace app\commands;

use app\models\User;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;


class RbacController extends Controller
{
    public function actionInit()
    {
        try
        {
            // yii migrate --migrationPath=@yii/rbac/migrations/

            $auth = Yii::$app->authManager;

            $user = $auth->createRole('user');
            $auth->add($user);

            $editor = $auth->createRole('editor');
            $auth->add($editor);

            $admin = $auth->createRole('admin');

            $auth->add($admin);

            $auth->addChild($admin, $editor);
            $auth->addChild($editor, $user);
            $auth->addChild($admin, $user);

            $this->stdout("Done!\n", Console::BG_GREEN);
            return ExitCode::OK;

        }
        catch (\Exception $e)
        {
        }

        $this->stdout("error\n", Console::BG_RED);
        return ExitCode::UNSPECIFIED_ERROR;
    }

    public function actionMakeAdmin($id)
    {

        try
        {

            if (!$id || is_int($id))
            {
                $this->stdout("Param 'id' must be set!\n", Console::BG_RED);
                return ExitCode::UNSPECIFIED_ERROR;
            }

            $user = (new User())->findIdentity($id);
            if (!$user)
            {
                $this->stdout("User witch id:'$id' is not found!\n", Console::BG_RED);
                return ExitCode::UNSPECIFIED_ERROR;
            }

            $auth = Yii::$app->authManager;

            $role = $auth->getRole('admin');
            $auth->revokeAll($id);
            $auth->assign($role, $id);

            $this->stdout("Done!\n", Console::BG_GREEN);
            return ExitCode::OK;

        }
        catch (\Exception $e)
        {
        }

        return ExitCode::UNSPECIFIED_ERROR;

    }

}