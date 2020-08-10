<?php

namespace app\modules\telegram\models;

use app\models\generated\Bots;
use app\models\generated\LogTelegramWebHook;
use app\utils\SaveError;
use Longman\TelegramBot\Telegram;
use Throwable;
use yii\base\Model;

class BotModel extends Model
{

    const BOT_STATUS = array('error' => 'error', 'paused' => 'paused', 'working' => 'working', 'finished' => 'finished');

    public $id;
    public $botId;
    public $botName;
    public $message;

    private $telegramHandle;

    function __construct($id)
    {
        parent::__construct();
        if ($this->setBot($id))
        {
            $this->setBotId();
            $this->setBotName();
            $this->setMessage();

        }
    }


    /**
     * @param $id
     * @return bool
     */
    public function setBot($id)
    {

        $model = Bots::findOne(['id' => $id]);

        if (empty($model))
            return false;

        try
        {
            $telegram = new Telegram($model['token'], $model['name']);
            $telegram->handle();

            $this->id = $id;
            $this->telegramHandle = $telegram;

            return true;

        }
        catch (Throwable $e)
        {
            SaveError::save(101, $e->getMessage(), 'setBot');
        }

        return false;

    }


    public function setBotId()
    {
        $this->botId = $this->telegramHandle->getBotId();
    }


    public function setBotName()
    {
        $this->botName = $this->telegramHandle->getBotUsername();
    }


    public function setMessage()
    {
        try
        {
            $callbackquery = $this->telegramHandle->getCommandObject('callbackquery');

            if ($message = $callbackquery->getUpdate()->getMessage() ?? $callbackquery->getUpdate()->getChannelPost())
            {
                $messageModel = new MessagesModel();

                $messageModel->messageIdTelegram = $message->getMessageId() ?? '';
                $messageModel->text = $message->getText() ?? '';
                $messageModel->type = $message->getFrom() ? MessagesModel::MESSAGE_TYPE['private'] : MessagesModel::MESSAGE_TYPE['channel'];
                $messageModel->botId = $this->id;
                $messageModel->senderType = $message->getViaBot() ? MessagesModel::SENDER_TYPE['bot'] : MessagesModel::SENDER_TYPE['telegramUser'];

                if ($chat = $message->getChat())
                {
                    $messageModel->userName = $chat->getUsername() ?? '';
                    $messageModel->firstName = $chat->getFirstName() ?? '';
                    $messageModel->lastName = $chat->getLastName() ?? '';
                    $messageModel->userIdTelegram = $chat->getId() ?? '';
                }

                $this->message = $messageModel;

            }

        }
        catch (Throwable $e)
        {
            $this->message = new MessagesModel();
            SaveError::save(1001, $e->getMessage(), 'setMessage');
        }

    }


    public function getMessages()
    {
        return $this->message;
    }

}