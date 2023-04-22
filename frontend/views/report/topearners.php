<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\TPHelper;

$this->title = 'Top Earners';
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
                            'attribute' => 'user_id',
                            'label' => 'Full Name',
                            'value' => function($model) {
                                return $model->user->profiles0 ? ucwords($model->user->profiles0[0]->first_name.' '.$model->user->profiles0[0]->last_name) : $model->user->username ;
                            }
                        ],
                        [
                            'attribute' => 'user_id',
                            'label' => 'Username',
                            'value' => function($model) {
                                return $model->user->username;
                            }
                        ],
                        [
                            'attribute' => 'current_balance',
                            'format' => 'currency',
                            'footer' => '<strong class="pull-right">Total : </strong>'
                        ],
                        [
                            'attribute' => 'totalearnings',
                            'format' => 'currency',
                            'label' => 'Total Earnings',
                            'footer' => TPHelper::columnTotal($dataProvider->models, 'totalearnings')
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
            
        </div>
    </div>
</div>
