<?php

namespace app\models\search;

use app\models\generated\Users;
use app\models\User;
use yii\data\ActiveDataProvider;

class UsersSearch extends \app\models\generated\Users
{

    public $id ;

    public function rules()
    {
        return [
            [['id'], 'integer'],
        ];
    }

    /**
     * @return ActiveDataProvider
     */
    public function search()
    {

        $query = Users::find()->select(['username','email','created','id'])->where(['deleted' => User::STATUS_NOT_DELETED]);

        if($this->validate())
            $query->filterWhere(['id' => $this->id]);



        $dataProvider = new ActiveDataProvider([
            'query' => $query,

            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $dataProvider;
    }


}