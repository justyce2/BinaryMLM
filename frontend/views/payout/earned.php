<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\TPHelper;

$this->title = 'Earned Income';
$this->params['breadcrumbs'][] = ['label' => 'Income Details', 'url' => ['earned']];
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
                            'attribute' => 'reason',
                            'label' => 'Amount Type',
                            'footer' => '<strong class="pull-right">Total : </strong>'
                        ],
                        [
                            'attribute' => 'amount',
                            'format' => 'currency',
                            'footer' => TPHelper::columnTotal($dataProvider->models, 'amount')
                        ],
                        'date:date',
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
            
        </div>
    </div>
</div>
</div>