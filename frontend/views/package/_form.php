<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Package */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
    <div class="row __tpfrm">
        <div class="col-md-3">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'point_volume')->textInput() ?>

            <div class="form-group frm_btn">
                <?= Html::submitButton(($model->isNewRecord) ? 'Create' : 'Update', ['class' => 'btn btn-info']) ?>
                <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-secondary']) ?>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>