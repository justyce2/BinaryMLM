<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use keygenqt\autocompleteAjax\AutocompleteAjax;
?>
<?php $form = ActiveForm::begin(); ?>
    <div class="row __tpfrm">
        <div class="col-md-3">
            <?= $form->field($model, 'msg_from')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>
            <?= $form->field($model, 'msg_to')->widget(AutocompleteAjax::classname(), [
                'multiple' => false,
                'url' => ['ajax/searchuser', 'incAdmin' => true],
            ])->label('Username') ?>
            <?= $form->field($model, 'subject')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
            <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>

            <div class="form-group frm_btn">
                <?= Html::submitButton(($model->isNewRecord) ? 'Send' : 'Edit', ['class' => 'btn btn-info']) ?>
                <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-secondary']) ?>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>