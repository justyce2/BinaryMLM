<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $model frontend\models\Profile */

$this->title = 'Choose Gateway';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header"><strong><?= Html::encode($this->title) ?></strong></div>
            <div class="card-body">

                <div class="paymentCont">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="headingWrap">
                        <h3 class="headingTop text-center">Choose your payment method</h3>
                        <p class="text-center">You will be redirected to certain payment gateway, If you have selected to pay online.</p>
                    </div>
                    <div class="paymentWrap text-center">
                        <!--<div class="btn-group paymentBtnGroup btn-group-justified" data-toggle="buttons">-->
                        
                        <div class="btn-group paymentBtnGroup btn-group-justified">
                           <!-- <label class="btn paymentMethod">
                                <div class="method paypal"></div>
                                <input type="radio" name="DynamicModel[pmethod]"value="Paypal">
                            </label>
                            <label class="btn paymentMethod">
                                <div class="method cheque"></div>
                                <input type="radio" name="DynamicModel[pmethod]"value="Cheque">
                            </label>-->
                            <?php if(Yii::$app->user->identity->user_role===2) {?>
                            <label class="btn paymentMethod">
                                <div class="method cash">Cash</div>
                                <input type="radio" name="DynamicModel[pmethod]"value="Cash"   >
                            </label>
                            <label class="btn paymentMethod">
                                <div class="method bank">Bank</div>
                                <input type="radio" name="DynamicModel[pmethod]"value="Bank" >
                            </label>
                           
                            <?php }?>
                            <label class="btn paymentMethod">
                                <div class="method flutterwave">Flutterwave(Ussd,Card)</div>
                                <input type="radio" name="DynamicModel[pmethod]"value="Flutterwave" checked="checked" > </label>
                        </div>
                    </div>
                    <div class="footerNavWrap clearfix">
                        <button type="submit" class="btn btn-danger pull-right">Continue</button>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>

            </div>
        </div>
    </div>
</div>