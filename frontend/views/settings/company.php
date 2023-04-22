<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use common\components\TPHelper;

$this->title = 'Company Profile';
$this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => ['system']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header"><strong><?= Html::encode($this->title) ?></strong></div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="site-tab" data-toggle="tab" href="#site" role="tab" aria-controls="site" aria-selected="true" aria-expanded="true">Site Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="social-tab" data-toggle="tab" href="#social" role="tab" aria-controls="social" aria-selected="false" aria-expanded="false">Social Profile</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="site" role="tabpanel" aria-labelledby="site-tab" aria-expanded="true">
                        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <?= $form->field($site_model, 'company_name')->textInput(['value' => TPHelper::getOption('company_name')]) ?>
                                    <?= $form->field($site_model, 'company_address')->textarea(['value' => TPHelper::getOption('company_address')]) ?>
                                    <?= $form->field($site_model, 'email')->textInput(['value' => TPHelper::getOption('email')]) ?>
                                    <?= $form->field($site_model, 'phone')->textInput(['value' => TPHelper::getOption('phone')]) ?>
                                    <?= $form->field($site_model, 'logo')->fileInput(['class' => 'form-control'])->hint('<img src="'.Url::to(['img/logo.png']).'">') ?>
                                    <?= $form->field($site_model, 'logo_inverse')->fileInput(['class' => 'form-control'])->hint('<img src="'.Url::to(['img/logo_inverse.png']).'">') ?>
                                    <?= $form->field($site_model, 'favicon')->fileInput(['class' => 'form-control'])->hint('<img src="'.Url::to(['img/favicon.ico']).'">') ?>

                                    <div class="form-group frm_btn">
                                        <?= Html::submitButton('Update', ['class' => 'btn btn-info']) ?>
                                        <?= Html::a('Cancel', ['site/index'], ['class' => 'btn btn-secondary']) ?>
                                    </div>
                                </div>
                            </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                    <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab" aria-expanded="false">
                        <?php $form = ActiveForm::begin(); ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <?= $form->field($social_model, 'facebook')->textInput(['value' => TPHelper::getOption('facebook')]) ?>
                                    <?= $form->field($social_model, 'twitter')->textInput(['value' => TPHelper::getOption('twitter')]) ?>
                                    <?= $form->field($social_model, 'instagram')->textInput(['value' => TPHelper::getOption('instagram')]) ?>
                                    <?= $form->field($social_model, 'google_plus')->textInput(['value' => TPHelper::getOption('google_plus')]) ?>

                                    <div class="form-group frm_btn">
                                        <?= Html::submitButton('Update', ['class' => 'btn btn-info']) ?>
                                        <?= Html::a('Cancel', ['site/index'], ['class' => 'btn btn-secondary']) ?>
                                    </div>
                                </div>
                            </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>