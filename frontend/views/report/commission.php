<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\TPHelper;

$this->title = 'Commission Report';
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['commission']];
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
                        [
                            'attribute' => 'trans_to',
                            'label' => 'Username',
                            'value' => function($model) {
                                return $model->transTo->username;
                            }
                        ],
                        [
                            'attribute' => 'trans_to',
                            'label' => 'Full Name',
                            'value' => function($model) {
                                return $model->transTo->profiles0 ? ucwords($model->transTo->profiles0[0]->first_name.' '.$model->transTo->profiles0[0]->last_name) : $model->transTo->username;
                            }
                        ],
                        [
                            'attribute' => 'reason',
                            'label' => 'Type',
                            'footer' => '<strong class="pull-right">Total : </strong>'
                        ],
                        [
                            'attribute' => 'amount',
                            'format' => 'currency',
                            'footer' => TPHelper::columnTotal($dataProvider->models, 'amount')
                        ],
                        'date:datetime',
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
            
        </div>
    </div>
</div>