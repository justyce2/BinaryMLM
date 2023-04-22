<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login or Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row justify-content-md-center pt-120">
    <div class="col-lg-5">
        <div class="login-container">
            <div class="login-box">
                <?php $form = ActiveForm::begin(); ?>
                <div class="login-logo">
                    <?= Html::img(['img/logo.png'], ['alt' => 'Techplait']) ?>
                </div><br><br>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <div class="actions clearfix">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary']) ?><br>
                    <?= Html::a('Forgot Password?', ['site/request-password-reset']) ?><br>
                    <?= Html::a('Don\'t have an account? Create now', ['site/register']) ?><br>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>