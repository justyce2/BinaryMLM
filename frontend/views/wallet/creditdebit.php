<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use keygenqt\autocompleteAjax\AutocompleteAjax;

$this->title = 'Credit/Debit';
$this->params['breadcrumbs'][] = ['label' => 'Ewallet', 'url' => ['creditdebit']];
$this->params['breadcrumbs'][] = $this->title;
$model->type='credit';
?>
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header"><strong><?= Html::encode($this->title) ?></strong></div>
            <div class="card-body">

                <?php $form = ActiveForm::begin(); ?>
                    <div class="row __tpfrm">
                        <div class="col-md-3">
                          
                            <?= $form->field($model, 'trans_to')->textInput()->label('User ID') ?>
                            <?= $form->field($model, 'amount')->textInput() ?>
                            <?= $form->field($model, 'type')->inline(true)->radioList(['credit' => 'Credit', 'debit' => 'Debit']) ?>

                            <div class="form-group">
                                <?= Html::submitButton('Proceed', ['class' => 'btn btn-danger']) ?>
                            </div>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
