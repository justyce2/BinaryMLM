<?php
use yii\bootstrap\ActiveForm;

$this->title = 'Choose Payment Method';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row justify-content-md-center pt-120">
    <div class="col-lg-6">
        <div class="login-container">
            <div class="login-box">
                
                <?php $form = ActiveForm::begin(); ?>
                <div class="headingWrap">
                    <h5 class="headingTop text-center">Choose your payment method</h5>
                    <p class="text-center">You will be redirected to certain payment gateway, If you have selected to pay online.</p>
                </div>
                <div class="paymentWrap text-center">
                <label class="btn paymentMethod">
                                <div class="method cash">Cash</div>
                                <input type="radio" name="DynamicModel[pmethod]"value="Cash" checked="checked" >
                            </label>
                            <label class="btn paymentMethod">
                                <div class="method bank">Bank</div>
                                <input type="radio" name="DynamicModel[pmethod]"value="Bank" >
                            </label> 
                            
           <label class="btn paymentMethod">
                                <div class="method flutterwave">Flutterwave(Ussd,Card)</div>
                                <input type="radio" name="DynamicModel[pmethod]"value="Flutterwave"  checked="checked" >
                            </label>
                         
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