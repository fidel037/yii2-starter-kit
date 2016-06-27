<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OauthClients */
/* @var $form yii\widgets\ActiveForm */

?>
<?=Html::csrfMetaTags()?>
<div class="oauth-clients-form">

    <?php $form = ActiveForm::begin();?>

    <?=$form->field($model, 'client_id')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'client_secret')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'redirect_uri')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'grant_types')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'scope')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'user_id')->textInput()?>

    <div class="form-group">
        <?=Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
