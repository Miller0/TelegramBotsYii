<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\generated\Bots */
/* @var $form ActiveForm */
?>
<div class="addBot">

    <?php $form = ActiveForm::begin(); ?>


        <?= $form->field($model, 'token') ?>
        <?= $form->field($model, 'name') ?>

        <div class="form-group">
            <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- addBot -->
<?php if(isset($error) && !empty($error)):?>

error


<?php endif;?>