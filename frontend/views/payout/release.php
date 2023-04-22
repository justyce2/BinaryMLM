<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use common\components\TPHelper;
use frontend\models\State;

$this->title = 'Release Payout';
$this->params['breadcrumbs'][] = ['label' => 'Payout', 'url' => ['release']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            
            <div class="card-header">
                <strong><?= Html::encode($this->title) ?></strong>
            </div>
            
            <?php $form = ActiveForm::begin(); ?>
            <div class="card-body">
                <?php Pjax::begin(['timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'post']]); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'label' => 'Username',
                            'value' => function($model) {
                                return $model->user->username;
                            }
                        ],
                        [
                            'label' => 'Full Name',
                            'value' => function($model) {
                                return $model->user->profiles0 ? ucwords($model->user->profiles0[0]->first_name.' '.$model->user->profiles0[0]->last_name) : $model->user->username ;
                            }
                        ],
                        
                        
                        [
                            'label' => 'State',
                         'value' =>  function($model) { 
                             $id = $model->user->profiles0[0]->state;
                             //return $id;
                              $stateModel = new State();
                           
      

                        return    State::findOne($id)->name;
                              
                          }
                          
                        ],
                        
                        [
                            'label' => 'Balance Amount',
                            'format' => 'raw',
                            'value' => function($model) {
                             return Yii::$app->formatter->format($model->current_balance, 'currency').' <span class="text-danger" title="Waiting for confirmation to deduct">( - '.TPHelper::waitingtoDeduct($model->user_id).')</span>';
                            }
                        ],
                        [
                            'label' => 'Payout Amount',
                            'format' => 'raw',
                            'value' => function($model) {
                            	$min = ($model->current_balance >= 10000)? $model->current_balance : 10000;
                                return Html::input('text', 'poutAmt_'.$model->user_id,$min , ['class' => 'form-control-sm']);
                            }
                        ],
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'checkboxOptions' => function($model) {
                                return ['value' => $model->user_id];
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'View Profile',
                            'template' => '{viewuserdata}',
                            'buttons' => [
                                'viewuserdata' => function($url, $model) {
                                    return $model->user->profiles0 ? Html::a('<span class="icon-eye"></span>', ['users/view', 'id' => $model->user->profiles0[0]->id, 'ajax' => true], ['target' => '_blank', 'title' => 'View Profile', 'data-pjax' => 0, 'onclick' => 'return loadModal(this)']) : '';
                                }
                            ],
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
                <?= Html::submitButton('Release', ['class' => 'btn btn-danger']) ?>
            </div>
            <?php ActiveForm::end(); ?>
            
        </div>
    </div>
</div>
</div>