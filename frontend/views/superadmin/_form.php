<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>
    <div class="row __tpfrm">
        <div class="col-md-3">
            <?= $form->field($model, 'username', ['enableAjaxValidation' => true])->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'transpass')->passwordInput() ?>

            <div class="form-group frm_btn">
                <?= Html::submitButton(($model->isNewRecord) ? 'Create' : 'Update', ['class' => 'btn btn-info']) ?>
                <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-secondary']) ?>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>