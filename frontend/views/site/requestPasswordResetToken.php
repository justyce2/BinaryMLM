<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Request Password Reset';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row justify-content-md-center pt-120">
    <div class="col-lg-5">
        <div class="login-container">
            <div class="login-box">
                <?php $form = ActiveForm::begin(); ?>
                    <div class="login-logo">
                        <strong><?= Html::encode($this->title) ?></strong>
                    </div><br><br>
                    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
                    <div class="actions clearfix">
                        <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?><br><br>
                        <?= Html::a('Go back to login page', ['site/login']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>