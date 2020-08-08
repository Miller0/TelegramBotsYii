<?php


namespace app\modules\telegram\models\form;


use app\models\generated\LogBots;
use app\utils\SaveError;
use yii\base\Model;

class LogBotsForm extends Model
{

    public $text;
    public $botId;

    public function rules()
    {
        return [
            [['text', 'botId'], 'required'],
            [['create'], 'safe'],
            [['botId'], 'integer'],
            [['text'], 'string', 'max' => 200],
        ];
    }


    function __construct($text, $botId)
    {
        parent::__construct();

        $this->text = $text;
        $this->botId = $botId;
        $this->create();
    }

    public function create()
    {
        try
        {
            $model = new LogBots();

            if ($this->validate())
            {
                $model->text = $this->text;
                $model->botId = $this->botId;
            }
            else
            {
                $model->text = 'unknown';
                $model->botId = 0;
            }

            return $model->save();
        }
        catch (\Exception $e)
        {
            SaveError::save(101, $e->getMessage());
        }

        return false;

    }


}