<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use keygenqt\autocompleteAjax\AutocompleteAjax;

$this->title = 'Transaction Password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header"><strong><?= Html::encode($this->title) ?></strong></div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tp-tab" data-toggle="tab" href="#tp" role="tab" aria-controls="tp" aria-selected="true" aria-expanded="true">Change Transaction Password</a>
                    </li>
                    <?php if(Yii::$app->user->identity->user_role===2) { ?>
                    <li class="nav-item">
                        <a class="nav-link" id="utp-tab" data-toggle="tab" href="#utp" role="tab" aria-controls="utp" aria-selected="false" aria-expanded="false">Change User Transaction Password</a>
                    </li>
                    <?php } ?>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="tp" role="tabpanel" aria-labelledby="tp-tab" aria-expanded="true">
                        <?php $form = ActiveForm::begin(); ?>
                            <div class="row __tpfrm">
                                <div class="col-md-3">
                                    <?= $form->field($model1, 'user_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>
                                    <?= $form->field($model1, 'currentPassword')->passwordInput() ?>
                                    <?= $form->field($model1, 'newPassword')->passwordInput() ?>
                                    <?= $form->field($model1, 'repeatPassword')->passwordInput() ?>

                                    <div class="form-group frm_btn">
                                        <?= Html::submitButton('Update', ['class' => 'btn btn-info']) ?>
                                        <?= Html::a('Cancel', ['site/index'], ['class' => 'btn btn-secondary']) ?>
                                    </div>
                                </div>
                            </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                    <div class="tab-pane fade" id="utp" role="tabpanel" aria-labelledby="utp-tab" aria-expanded="false">
                        <?php $form = ActiveForm::begin(); ?>
                            <div class="row __tpfrm">
                                <div class="col-md-3">
                                    <?= $form->field($model2, 'user_id')->widget(AutocompleteAjax::classname(), [
                                        'multiple' => false,
                                        'url' => ['ajax/searchuser'],
                                    ])->label('Username') ?>
                                    <?= $form->field($model2, 'new_Password')->passwordInput() ?>
                                    <?= $form->field($model2, 'repeat_Password')->passwordInput() ?>

                                    <div class="form-group frm_btn">
                                        <?= Html::submitButton('Change', ['class' => 'btn btn-info']) ?>
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