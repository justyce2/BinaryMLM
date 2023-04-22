<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$bc_url=(Yii::$app->user->identity->user_role===2) ? ['creditdebit'] : ['history'] ;
$this->title = 'Transfer History';
$this->params['breadcrumbs'][] = ['label' => 'Ewallet', 'url' => $bc_url];
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
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'trans_from',
                            'format' => 'raw',
                            'value' => function($model) {
                                return Html::a($model->transFrom->username, ['users/view', 'id' => $model->transFrom->profiles0[0]->id, 'ajax' => true], ['target' => '_blank', 'title' => 'View Profile', 'data-pjax' => 0, 'onclick' => 'return loadModal(this)', 'class' => 'blue_text']);
                            },
                            'visible' => (Yii::$app->user->identity->user_role===2)
                        ],
                        [
                            'attribute' => 'trans_to',
                            'format' => 'raw',
                            'value' => function($model) {
                                return (Yii::$app->user->identity->user_role===2) ? Html::a($model->transTo->username, ['users/view', 'id' => $model->transTo->profiles0[0]->id, 'ajax' => true], ['target' => '_blank', 'title' => 'View Profile', 'data-pjax' => 0, 'onclick' => 'return loadModal(this)', 'class' => 'blue_text']) : $model->transTo->username;
                            }
                        ],
                        'amount:currency',
                        'transaction_fee:currency',
                        'date:datetime',
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
            
        </div>
    </div>
</div>
</div>