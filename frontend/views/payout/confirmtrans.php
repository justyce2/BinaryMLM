<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;

$this->title = 'Confirm Transfer';
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
                                return $model->transTo->username;
                            }
                        ],
                        [
                            'label' => 'Full Name',
                            'value' => function($model) {
                                return $model->transTo->profiles0 ? ucwords($model->transTo->profiles0[0]->first_name.' '.$model->transTo->profiles0[0]->last_name) : $model->transTo->username;
                            }
                        ],
                        [
                            'label' => 'Acc Name',
                            'value' => function($model) {
                                return $model->transTo->profiles0[0]->accountname;
                            }
                        ],
                        [
                            'label' => 'Acc No',
                            'value' => function($model) {
                                return $model->transTo->profiles0[0]->accountno;
                            }
                        ],
                        [
                            'label' => 'Bank',
                            'value' => function($model) {
                               return $model->transTo->profiles0[0]->bankname;
                            }
                        ],
                        'amount:currency',
                        'date:date',
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'checkboxOptions' => function($model) {
                                return ['value' => $model->id];
                            }
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
                <?= Html::submitButton('Confirm', ['class' => 'btn btn-danger']) ?>
            </div>
            <?php ActiveForm::end(); ?>
            
        </div>
    </div>
</div>
</div>