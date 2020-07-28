<?php

/* @var $this yii\web\View */

$this->title = 'Admin';

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url; ?>


<?=
 GridView::widget([
    'dataProvider' => $dataProvider,
     'filterModel' => $searchModel,
     'columns' =>
         [
             [
                 'label' => 'id',
                 'attribute' => 'id',
                 'filterOptions' => ['style' => 'width: 60px']
             ],

             [
                 'label' => 'email',
                 'attribute' => 'email',
                 'filter' => false,
             ],

             [
                 'label' => 'username',
                 'attribute' => 'username',
                 'filter' => false,
             ],

             [
                 'label' => 'created',
                 'attribute' => 'created',
                 'filter' => false,
             ],

             [
                 'class' => 'yii\grid\ActionColumn',
                 'template' => '{delete}',
                 'buttons' => [
                     'delete' => function ($url,$model) {
                         return Html::a(
                             '<span class="glyphicon glyphicon-trash"></span>',
                             Url::toRoute(['admin/deleted-user', 'id' => $model['id']]));
                     },
                 ],
             ],

         ]
]);

?>