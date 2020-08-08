<?php


namespace app\modules\telegram\models;


use app\models\generated\Chats;
use app\models\generated\Messages;
use app\models\generated\TelegramUser;
use app\modules\telegram\models\search\TelegramUserSearch;
use yii\base\Model;

class MessagesModel extends Model
{

    const MESSAGE_TYPE = array('private' => 'private', 'channel' => 'channel');
    const MESSAGE_STATUS = array('send' => 'send', 'error' => 'error', 'unknown' => 'unknown');
    const SENDER_TYPE = array('user' => 'user', 'bot' => 'bot','telegramUser' => 'telegramUser');

    public $messageIdTelegram;
    public $userIdTelegram;
    public $userName;
    public $firstName;
    public $lastName;
    public $type;
    public $text;
    public $botId;
    public $senderType;

    public function create()
    {
        if($this->userIdTelegram)
        $modelChat = Chats::findOne(['telegramUserId' => TelegramUserSearch::searchById($this->userIdTelegram)['id'],'botId' => $this->botId]);

        if (empty($modelChat))
        {
            $modelChat = $this->createChat();
            if (empty($modelChat))
                return false;
        }
        else
        {
            $modelChat->update = date('Y-m-d H:i:s');
            $modelChat->save();
        }

        $modelMessage = new Messages();
        $modelMessage->text = $this->text;
        $modelMessage->chatId = $modelChat->id;
        $modelMessage->senderId = $modelChat->telegramUserId;
        $modelMessage->senderType = $this->senderType;
        $modelMessage->status = self::MESSAGE_STATUS['send'];

        if($modelMessage->validate())
            if($modelMessage->save())
                return true;

        return false;

    }


    public function createChat()
    {

        if ($modelUserTelegram = $this->createUserTelegram())
        {
            $modelChat = new Chats();
            $modelChat->botId = $this->botId;
            $modelChat->telegramUserId = $modelUserTelegram->id;
            $modelChat->name = $this->userName;

            if ($modelChat->validate())
                if ($modelChat->save())
                    return $modelChat;
        }

        return false;

    }

    public function createUserTelegram()
    {
        $modelUserTelegram = TelegramUser::findOne(['telegramId' =>$this->userIdTelegram ]);

        if(empty($modelUserTelegram))
        {
            $modelUserTelegram = new TelegramUser();
            $modelUserTelegram->telegramId = $this->userIdTelegram;
            $modelUserTelegram->username = $this->userName;
            $modelUserTelegram->firstName = $this->firstName;
            $modelUserTelegram->lastName = $this->lastName;
            $modelUserTelegram->type = $this->type;

            if ($modelUserTelegram->validate())
                if ($modelUserTelegram->save())
                    return $modelUserTelegram;
        }

        return $modelUserTelegram;
    }


}