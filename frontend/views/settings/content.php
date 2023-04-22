<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\TPHelper;
use dosamigos\ckeditor\CKEditor;

$this->title = 'Content Management';
$this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => ['system']];
$this->params['breadcrumbs'][] = $this->title;
$t_model->terms_and_conditions=TPHelper::getOption('terms_and_conditions');
$p_model->privacy_policy=TPHelper::getOption('privacy_policy');
?>
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header"><strong><?= Html::encode($this->title) ?></strong></div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="terms-tab" data-toggle="tab" href="#terms" role="tab" aria-controls="terms" aria-selected="true" aria-expanded="true">Terms and Conditions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="privacy-tab" data-toggle="tab" href="#privacy" role="tab" aria-controls="privacy" aria-selected="false" aria-expanded="false">Privacy Policy</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="terms" role="tabpanel" aria-labelledby="terms-tab" aria-expanded="true">
                        <?php $form = ActiveForm::begin(); ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <?= $form->field($t_model, 'terms_and_conditions')->widget(CKEditor::className(), [
                                        'options' => ['rows' => 6],
                                        'preset' => 'basic'
                                    ]) ?>

                                    <div class="form-group frm_btn">
                                        <?= Html::submitButton('Update', ['class' => 'btn btn-info']) ?>
                                        <?= Html::a('Cancel', ['site/index'], ['class' => 'btn btn-secondary']) ?>
                                    </div>
                                </div>
                            </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                    <div class="tab-pane fade" id="privacy" role="tabpanel" aria-labelledby="privacy-tab" aria-expanded="false">
                        <?php $form = ActiveForm::begin(); ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <?= $form->field($p_model, 'privacy_policy')->widget(CKEditor::className(), [
                                        'options' => ['rows' => 6],
                                        'preset' => 'basic'
                                    ]) ?>

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