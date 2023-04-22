<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use frontend\models\Package;
use frontend\models\Country;
use keygenqt\autocompleteAjax\AutocompleteAjax;
use frontend\models\User;

$this->title = 'INTEREST FORM FOR JERUSALEM VACATION TOUR';
$this->params['breadcrumbs'][] = $this->title;

if(Yii::$app->request->get('ref')) {
    $uInfo = User::findOne(['username' => Yii::$app->request->get('ref')]);
    $model->referrer = $uInfo->id;
}
?>
<div class="row justify-content-md-center pt-120">
    <div class="col-lg-6">
        <div class="login-container">
            <div class="login-box">
                <?php $form = ActiveForm::begin(); ?>
                    <div class="login-logo">
                        <strong><?= Html::encode($this->title) ?></strong>
                    </div><br><br>
                    <div class="container">
                        
                        <span class="btn btn-danger" style="width: 100%;">PERSONAL INFORMATION</span>
                        <div class="row">
                            <div class="col-md-6">
                              <!--  <?= $form->field($model, 'referrer', ['enableAjaxValidation' => true])->widget(AutocompleteAjax::classname(), [
                                    'options' => ['autocomplete' => 'off'],
                                    'multiple' => false,
                                    'url' => ['ajax/searchuser', 'incAdmin' => true],
                                ]) ?>-->
                                
                                
                                 <?= $form->field($model, 'referrer', ['enableAjaxValidation' => false])->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'position', ['enableAjaxValidation' => true])->dropDownList([ 'Left' => 'Left', 'Right' => 'Right'], ['prompt' => 'Choose position']) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'placement')->textInput(['readonly' => true]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= //$form->field($model, 'pack_id')->dropDownList(ArrayHelper::map(Package::find()->where(['status' => 'Active'])->asArray()->all(), 'id', function($model) { return $model['name'] .' -- '. Yii::$app->formatter->format($model['amount'], 'currency'); }), ['prompt' => 'Choose package']);
                              //  $form->field($model, 'pack_id')->dropDownList(ArrayHelper::map(Package::find()->where(['id' => 1])->asArray()->all(), 'id', function($model) { return $model['name'] .' -- '. Yii::$app->formatter->format($model['amount'], 'currency'); }), ['prompt' => 'Choose package']);  
  $form->field($model, 'pack_id')->dropDownList(ArrayHelper::map(Package::find()->where(['id' => 1])->asArray()->all(), 'id', function($model) { return $model['name'] ;}), ['readonly' => 'yes']);                              
                                 ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($user, 'username', ['enableAjaxValidation' => true])->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($user, 'password')->passwordInput() ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($user, 'email', ['enableAjaxValidation' => true])->textInput(['maxlength' => true]) ?>
                            </div>
                         <div class="col-md-6">
                             <?= $form->field($model, 'mobile_no')->textInput(['maxlength' => true]) ?></div>
                             
                             <!--   <div class="col-md-6">
                                <?= $form->field($model, 'blockchain_address')->textInput(['maxlength' => true]) ?>
                            </div>-->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'gender')->dropDownList([ 'Male' => 'Male', 'Female' => 'Female', 'Rather not say' => 'Rather not say', ], ['prompt' => 'Choose gender']) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'dob')->widget(DatePicker::className(),['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control', 'autocomplete' => 'off']]) ?>
                            </div>
                        </div>
                      <!--  <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'mobile_no')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'landline_no')->textInput(['maxlength' => true]) ?>
                            </div>
                        </div>-->
                        <div class="row">
                            <div class="col-md-12">
                                <?= $form->field($model, 'address_line_1')->textInput(['maxlength' => true]) ?>
                            </div>
                          <!--  <div class="col-md-6">
                                <?= $form->field($model, 'address_line_2')->textInput(['maxlength' => true]) ?>
                            </div>-->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'country')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Country::find()->asArray()->all(), 'id', 'name'),
                                'options' => ['placeholder' => 'Choose country'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'state')->widget(DepDrop::classname(), [
                                    'type' => DepDrop::TYPE_SELECT2,
                                    'data' => [$model->state => !empty($model->state)?$model->state0->name:''],
                                    'pluginOptions' => [
                                        'depends' => ['profile-country'],
                                        'placeholder' => 'Choose State',
                                        'initialize' => false,
                                        'url' => Url::to(['ajax/states'])
                                    ]
                                ]); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'city')->widget(DepDrop::classname(), [
                                    'type' => DepDrop::TYPE_SELECT2,
                                    'data' => [$model->city => !empty($model->city)?$model->city0->name:''],
                                    'pluginOptions' => [
                                        'depends' => ['profile-state'],
                                        'placeholder' => 'Choose City',
                                        'initialize' => false,
                                        'url' => Url::to(['ajax/cities'])
                                    ]
                                ]); ?>
                            </div>
                          <!--  <div class="col-md-6">
                                <?= $form->field($model, 'zip_code')->textInput(['maxlength' => true]) ?>
                            </div>-->
                        </div>
                        <br />
                          <span class="btn btn-danger" style="width: 100%;">BANKING INFORMATION</span>
                        <div class="row">
                           <!-- <div class="col-md-6">
                                <?= $form->field($model, 'facebook')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'twitter')->textInput(['maxlength' => true]) ?>
                            </div> -->
                            
                          
                            <div class="col-md-6">
                            
                             <?= $form->field($model, 'bankname')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'accountname')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'accountno')->textInput(['maxlength' => true]) ?>
                </div>
                        </div>
                          <br />
                         <span   class="btn btn-danger" style="width: 100%;"> TRAVEL HISTORY</span>
                         <div class="row">
                           <div class="col-md-12">
                    <span>Have you traveled abroad before?</span>
                      <input type="radio" id="No" name="traveledbefore" value="NO">
<label for="NO">No</label>
<input  type="radio" id="Yes" name="traveledbefore" value="Yes">
<label for="Yes">Yes</label><br>

                </div>  
                
                <div class="col-md-12">
                     <label for="fname">IF Yes Where?</label>
  <input class="form-control" type="text" id="towhere" name="towhere"><br><br>
                </div>
                
                 <div class="col-md-12">
                    <span>Do You Wish To Travel To Israel?</span>
                      <input  type="radio" id="No" name="travelisrael" value="NO">
<label for="NO">No</label>
<input  type="radio" id="Yes" name="travelisrael" value="Yes">
<label for="Yes">Yes</label><br>

                </div>  
                         </div>
                        <div class="actions clearfix">
                            <?= Html::submitButton('Register', ['class' => 'btn btn-primary']) ?><br>
                            <?= Html::a('Do you have an account? Login now', ['site/login']) ?>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php
$post_url = Url::to(['ajax/getplacement']);
$script = <<<JS
    $('#profile-position').on('change', function(e) {
        getPlc();
    });
    $('#w1').on('change', function(e) {
        getPlc();
    });
        
    function getPlc() {
        var ref = $('#w1').val();
        var pos = $('#profile-position').val();
        
        if(ref!='' && pos!='') {
            $.ajax({
               url: "$post_url",
               data: {sponsor: ref, position: pos},
               success: function(result) {
                   $('#profile-placement').val(result);
               }
            });
        }
    }
JS;
$this->registerJs($script);
?>