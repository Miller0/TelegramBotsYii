<?php


namespace app\modules\telegram\models;

use app\modules\telegram\models\form\ChatsForm;
use app\modules\telegram\models\form\MessageForm;
use app\modules\telegram\models\form\TelegramUserForm;
use app\modules\telegram\models\search\TelegramUserSearch;
use app\utils\SaveError;

class BotMessagesModel
{

    const MESSAGE_TYPE = array('private' => 'private', 'channel' => 'channel');
    const MESSAGE_STATUS = array('send' => 'send', 'error' => 'error', 'unknown' => 'unknown', 'waitingSend' => 'waitingSend');
    const SENDER_TYPE = array('user' => 'user', 'bot' => 'bot', 'telegramUser' => 'telegramUser');

    public $messageIdTelegram;
    public $userIdTelegram;
    public $userName;
    public $firstName;
    public $lastName;
    public $type;
    public $text;
    public $botId;
    public $senderType;
    public $status;
    public $senderId;
    public $chatId;

    public function saveMessage()
    {
        try
        {

            $chat = $this->getChat();

            $chatId = $chat['id'] ?? 0;
            if ($chatId == 0)
                SaveError::save(1003, '', __FUNCTION__);


            if (!$this->saveTextMessage())
                SaveError::save(1003, 'saveTextMessage()', __FUNCTION__);
            else
                return true;


        }
        catch (\Exception $e)
        {
            SaveError::save(1003, $e->getMessage(), __FUNCTION__);
        }

        return false;

    }


    private function saveTextMessage()
    {

        if ($this->senderType == self::SENDER_TYPE['telegramUser'])
        {
            $message = new MessageForm();
            $message->text = $this->text;
            $message->chatId = $this->chatId;
            $message->senderId = $this->senderId;
            $message->senderType = $this->senderType;
            $message->status = $this->status;
            if ($message->create())
            {
                ChatsForm::overwriteUpdateById($this->chatId);
                return true;
            }

        }

        return false;
    }


    private function getSender()
    {
        $tUser = TelegramUserSearch::searchByTelegramId($this->userIdTelegram);
        if (empty($tUser['id']))
        {
            $tUser = $this->addSender();
        }

        $this->senderId = $tUser['id'] ?? 0;
        return $tUser;
    }


    private function addSender()
    {
        $tUser = new TelegramUserForm();
        $tUser->telegramId = $this->userIdTelegram;
        $tUser->username = $this->userName;
        $tUser->firstName = $this->firstName;
        $tUser->lastName = $this->lastName;
        $tUser->type = $this->type;
        return $tUser->create() ?? [];
    }


    private function getChat()
    {
        $tUser = $this->getSender();

        if (empty($tUser['id']))
        {
            $chat = $this->createChat();
            return $chat;
        }

        $chat = ChatsForm::find()->where(['telegramUserId' => $tUser['id'], 'botId' => $this->botId])->asArray()->one();
        if (empty($chat))
            $chat = $this->createChat();

        $this->chatId = $chat['id'] ?? 0;
        return $chat ?? [];

    }


    private function createChat()
    {
        if (empty($this->senderId))
            return [];

        $chat = new ChatsForm();
        $chat->botId = $this->botId;
        $chat->telegramUserId = $this->senderId;
        $chat->name = $this->userName;
        return $chat->create() ?? [];
    }
}