<?php

namespace app\modules\telegram\models;

use app\models\generated\Bots;
use app\models\generated\Chats;
use app\models\generated\Messages;
use app\utils\SaveError;
use Longman\TelegramBot\Telegram;
use Throwable;


class BotModel
{

    const BOT_STATUS = array('error' => 'error', 'paused' => 'paused', 'working' => 'working', 'finished' => 'finished');

    public $id;
    public $telegramBotId;
    public $botName;
    public $message;

    private $telegram;
    private $telegramHandle;


    /**
     * BotModel constructor.
     * @param $id
     * @param bool $update
     */
    function __construct($id, $getUpdate = false)
    {
        $this->setBot($id);
        $getUpdate ? $this->getUpdate() : true;
    }


    /**
     * @param $id
     * @return bool
     */
    private function setBot($id)
    {

        $bot = Bots::findOne(['id' => $id]);

        if (empty($bot))
            return false;

        try
        {
            $telegram = new Telegram($bot['token'], $bot['name']);

            $this->id = $id;
            $this->telegram = $telegram;
            return true;
        }
        catch (Throwable $e)
        {
            SaveError::save(101, $e->getMessage(), 'setBot');
        }

        return false;

    }


    private function setBotId()
    {
        if (empty($this->telegramHandle))
            $this->setUpdate();

        $this->telegramBotId = $this->telegramHandle->getBotId();
    }


    private function setBotName()
    {
        if (empty($this->telegramHandle))
            $this->setUpdate();

        $this->botName = $this->telegramHandle->getBotUsername();
    }


    private function setMessageHandle()
    {
        try
        {
            if (empty($this->telegramHandle))
                $this->setUpdate();

            $callbackquery = $this->telegramHandle->getCommandObject('callbackquery');

            if ($message = $callbackquery->getUpdate()->getMessage() ?? $callbackquery->getUpdate()->getChannelPost())
            {
                $messageModel = new BotMessagesModel();

                $messageModel->messageIdTelegram = $message->getMessageId() ?? '';
                $messageModel->text = $message->getText() ?? '';
                $messageModel->type = $message->getFrom() ? BotMessagesModel::MESSAGE_TYPE['private'] : BotMessagesModel::MESSAGE_TYPE['channel'];
                $messageModel->botId = $this->id;
                $messageModel->senderType = $message->getViaBot() ? BotMessagesModel::SENDER_TYPE['bot'] : BotMessagesModel::SENDER_TYPE['telegramUser'];
                $messageModel->status = BotMessagesModel::MESSAGE_STATUS['send'];

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
            SaveError::save(1001, $e->getMessage(), 'setMessage');
            $this->message = new BotMessagesModel();
        }
    }


    public function getUpdate()
    {
        try
        {
            $telegram = $this->telegram;
            $telegram->handle();
            $this->telegramHandle = $telegram;
            $this->setBotName();
            $this->setBotId();
            $this->setMessageHandle();
        }
        catch (\Exception $e)
        {
            SaveError::save(1001, $e->getMessage(), 'getUpdate');
        }
    }


    public function saveMessage()
    {
        if (empty($this->message))
            return false;

        return $this->message->saveMessage();
    }


    public function sendMessage()
    {
        if (empty($this->id))
            return false;

        if (empty($this->message))
            return false;

        $chats = Chats::find()->select(['id'])->where(['deleted' => 0, 'botId' => $this->id])->asArray()->all();
        if (empty($chat))
            return false;

        foreach ($chats as $chat)
        {
            $messagesArr = Messages::find()->where(['deleted' => 0, 'chatId' => $chat['id'], 'status' => BotMessagesModel::MESSAGE_STATUS['unknown']])->asArray()->all();

            foreach ($messagesArr as $messageArr)
            {
                $message = new BotMessagesModel();
                $message->text = $messageArr['text'];
            }


        }

        return false;
    }

}