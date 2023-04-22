<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\components\TPHelper;

$this->title = 'System Settings';
$this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => ['system']];
$this->params['breadcrumbs'][] = $this->title;
$com_model->calculation_period=TPHelper::getOption('calculation_period');
$ref_model->refferal_bonus_enabled=TPHelper::getOption('refferal_bonus_enabled');
$ref_model->refferal_bonus_type=TPHelper::getOption('refferal_bonus_type');
?>
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header"><strong><?= Html::encode($this->title) ?></strong></div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="com-tab" data-toggle="tab" href="#com" role="tab" aria-controls="com" aria-selected="true" aria-expanded="true">Compensation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="ref-tab" data-toggle="tab" href="#ref" role="tab" aria-controls="ref" aria-selected="false" aria-expanded="false">Referral Bonus</a>
                    </li
                    <li class="nav-item">
                        <a class="nav-link" id="oth-tab" data-toggle="tab" href="#oth" role="tab" aria-controls="oth" aria-selected="false" aria-expanded="false">Others</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="com" role="tabpanel" aria-labelledby="com-tab" aria-expanded="true">
                        <?php $form = ActiveForm::begin(); ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <br><h6 class="text-muted">Binary Settings</h6><hr>
                                    <?= $form->field($com_model, 'calculation_period')->dropDownList(['daily' => 'Daily', 'weekly' => 'Weekly', 'monthly' => 'Monthly'], ['prompt' => 'None']) ?>
                                    <?= $form->field($com_model, 'maximum_commission_eligibility_level')->textInput(['value' => TPHelper::getOption('maximum_commission_eligibility_level')]) ?>
                                    
                                    <br><h6 class="text-muted">Binary Commission</h6><hr>
                                    <?= $form->field($com_model, 'binary_commission')->textInput(['value' => TPHelper::getOption('binary_commission')])->hint('<i><small> Binary Commission = ( Week Leg PV * Commission Percentage) / 100 </small></i>')->label('Commission Percentage') ?>

                                    <div class="form-group frm_btn">
                                        <?= Html::submitButton('Update', ['class' => 'btn btn-info']) ?>
                                        <?= Html::a('Cancel', ['site/index'], ['class' => 'btn btn-secondary']) ?>
                                    </div>
                                </div>
                            </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                    <div class="tab-pane fade" id="ref" role="tabpanel" aria-labelledby="ref-tab" aria-expanded="false">
                        <?php $form = ActiveForm::begin(); ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <?= $form->field($ref_model, 'refferal_bonus_enabled')->checkbox() ?>
                                    <?= $form->field($ref_model, 'refferal_bonus_type')->inline(true)->radioList(['percentage' => 'Percentage', 'flat' => 'Flat']) ?>
                                    <?= $form->field($ref_model, 'refferal_bonus_value')->textInput(['value' => TPHelper::getOption('refferal_bonus_value')]) ?>

                                    <div class="form-group text-center">
                                        <?= Html::submitButton('Update', ['class' => 'btn btn-info']) ?>
                                        <?= Html::a('Cancel', ['site/index'], ['class' => 'btn btn-secondary']) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="alert custom alert-info info-stats2">
                                <i class="icon-info-large"></i>
                                If the type of commission is flat,<br>
                                <strong>Referral Bonus = Bonus Amount</strong><br>
                                In the case of percentage;<br>
                                <strong>Referral Bonus = (Bonus Amount * Package Amount) / 100</strong>
                            </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                    <div class="tab-pane fade" id="oth" role="tabpanel" aria-labelledby="oth-tab" aria-expanded="false">
                        <?php $form = ActiveForm::begin(); ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <?= $form->field($oth_model, 'service_charge')->textInput(['value' => TPHelper::getOption('service_charge')])->label('Service Charge (%)') ?>
                                    <?= $form->field($oth_model, 'tds')->textInput(['value' => TPHelper::getOption('tds')])->label('TDS (%)') ?>
                                    <?= $form->field($oth_model, 'transaction_fee')->textInput(['value' => TPHelper::getOption('transaction_fee')]) ?>

                                    <div class="form-group frm_btn">
                                        <?= Html::submitButton('Update', ['class' => 'btn btn-info']) ?>
                                        <?= Html::a('Cancel', ['site/index'], ['class' => 'btn btn-secondary']) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="alert custom alert-info info-stats2">
                                <i class="icon-info-large"></i>
                                For each commission calculation, service charge and TDS will be deducted. <br>
                                Transaction fee will be added for every Ewallet transaction.
                            </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>