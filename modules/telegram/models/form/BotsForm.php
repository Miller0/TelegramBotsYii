<?php


namespace app\modules\telegram\models\form;


use app\models\generated\Bots;
use app\modules\telegram\models\BotModel;
use app\utils\SaveError;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;
use Yii;
use yii\base\Model;
use yii\helpers\Url;

class BotsForm extends Model
{


    public $token;
    public $id;
    public $key;
    public $name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token' , 'name'], 'required'],
            [['token','name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'token' => 'Token',
            'webHookKey' => 'Web Hook Key',
            'create' => 'Create',
            'status' => 'Status',
        ];
    }

    public function create()
    {
        if (!$this->validate())
            return false;

        if ($this->id = $this->saveToken())
        {
            if ($this->addBot())
                return true;
        }

        return false;
    }

    public function saveToken()
    {
        $bot = new Bots();

        $bot->token = $this->token;
        $bot->name = $this->name;
        $bot->userId = Yii::$app->user->getId();
        $bot->status = BotModel::BOT_STATUS['error'];
        $bot->webHookKey = $this->generateKey();

        if ($bot->validate() && $bot->save())
            return $bot->id;
        else
            return false;

    }

    public function addBot()
    {
        if (empty($this->id))
            return false;

        if ($bot = Bots::findOne(['id' => $this->id, 'status' => BotModel::BOT_STATUS['error']]))
        {
            $this->key = $bot->webHookKey;
            if ($this->setWebHook())
            {
                $bot->status = BotModel::BOT_STATUS['working'];

                if ($bot->validate())
                    $bot->save();

                return true;
            }

        }

        return false;

    }

    public function setWebHook()
    {
        try
        {

            $telegram = new Telegram($this->token, '1');
            $result = $telegram->setWebhook(Url::toRoute(['web-hook/' . $this->key], 'https'));
            if ($result->isOk())
            {
                return $result->getDescription();
            }

        }
        catch (TelegramException $e)
        {

            SaveError::save(1000, $e->getMessage(), 'setWebHook()');
        }

        return false;

    }

    public function generateKey()
    {
        return base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }


}