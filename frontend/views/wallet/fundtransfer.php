<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use common\components\TPHelper;
use keygenqt\autocompleteAjax\AutocompleteAjax;

$bc_url=(Yii::$app->user->identity->user_role===2) ? ['creditdebit'] : ['history'] ;
$this->title = 'Fund Transfer';
$this->params['breadcrumbs'][] = ['label' => 'Ewallet', 'url' => $bc_url];
$this->params['breadcrumbs'][] = $this->title;
$model->type='credit';
if(Yii::$app->user->identity->user_role===1) {
    $model->trans_from=Yii::$app->user->identity->id;
}
$options=(Yii::$app->user->identity->user_role===1) ? ['readonly' => true, 'onchange' => 'getCurBal(this.value);'] : ['onchange' => 'getCurBal(this.value);'];
?>
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header"><strong><?= Html::encode($this->title) ?></strong></div>
            <div class="card-body">

                <?php $form = ActiveForm::begin(); ?>
                    <div class="row __tpfrm">
                        <div class="col-md-3">
                            <?= $form->field($model, 'trans_from')->widget(AutocompleteAjax::classname(), [
                                'options' => $options,
                                'multiple' => false,
                                'url' => ['ajax/searchuser'],
                            ])->label('Username') ?>
                            <p id="curBal" class="text-danger" style="margin-left: 15px;font-weight: bold;"></p>
                            
                            <?= $form->field($model, 'trans_to')->widget(AutocompleteAjax::classname(), [
                                'multiple' => false,
                                'url' => ['ajax/searchuser'],
                            ])->label('Transfer To (Username)') ?>
                            <?= $form->field($model, 'amount')->textInput() ?>

                            <div class="form-group">
                                <?= Html::submitButton('Proceed', ['class' => 'btn btn-danger', 'data-confirm' => 'Proceed with caution! Wallet amount will be deducted and transferred to the selected user.']) ?>
                            </div>
                            <div class="alert custom alert-info info-stats2">
                                <i class="icon-info-large"></i>
                                <span class="help-block-error" style="font-weight: bold;"> Transaction Fee (Charged for every transaction) : <?= Yii::$app->formatter->format(TPHelper::getOption('transaction_fee'), 'currency') ?></span>
                            </div>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
<?php
$getUrl=Url::to(['ajax/getcurbal']);
$username=(Yii::$app->user->identity->user_role===1) ? Yii::$app->user->identity->username : '';
$tpScript=<<< JS
     $('#curBal').hide();
    $(function() {
      getCurBal("$username");
    });
    function getCurBal(username) {
        $.post("$getUrl", { username: username }, function(data){
            if(data!='') {
                $('#curBal').html(username+'\'s Current Balance : '+data);
                $('#curBal').show();
            }
            else {
                $('#curBal').html('');
                $('#curBal').hide();
            }
        });
    }
JS;
$this->registerJs($tpScript, yii\web\View::POS_END);
?>