<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-screen row align-items-center">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="login-container">
            <div class="row no-gutters">
                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                    <div class="login-box">
                        <?php $form = ActiveForm::begin(); ?>
                        <span class="login-logo">
                            <?= Html::img(['img/logo_sticky.png'], ['alt' => 'Matrix MLM']) ?>
                        </span>
                        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                        <?= $form->field($model, 'email') ?>
                        <?= $form->field($model, 'password')->passwordInput() ?>
                        <div class="actions clearfix">
                            <?= Html::submitButton('Signup', ['class' => 'btn btn-primary']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>

                        <div class="or"></div>
                        <div class="mt-4">
                            Have an account? <?= Html::a('Login Now', ['site/login']); ?>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-7 col-md-6 col-sm-12">
                    <div class="login-slider"></div>
                </div>
            </div>
        </div>
    </div>
</div>
