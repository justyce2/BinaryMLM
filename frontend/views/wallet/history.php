<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\TPHelper;

$this->title = 'Ewallet Details';
$this->params['breadcrumbs'][] = ['label' => 'Ewallet', 'url' => ['history']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            
            <div class="card-header">
                <strong><?= Html::encode($this->title) ?></strong>
            </div>
            
            <div class="card-body">
                <?php Pjax::begin(['timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'post']]); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'showFooter' => true,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'date:datetime',
                        [
                            'attribute' => 'reason',
                            'label' => 'Description',
                            'value' => function($model) {
                                $reason='';
                                if($model->reason==='From Credit/Debit') {
                                    $reason=$model->type.'ed by '.$model->transFrom->username;
                                }
                                else if($model->reason==='Payout Release') {
                                    $reason='Payout released by '.$model->transFrom->username;
                                }
                                else {
                                    $reason=$model->reason.' from '.$model->transFrom->username;
                                }
                                return (strtolower($reason));
                            }
                        ],
                        'type',
                        'amount:currency'
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
            
        </div>
    </div>
</div>
</div>