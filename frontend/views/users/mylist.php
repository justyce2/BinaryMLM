<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\TPHelper;

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">

            <div class="card-header">
                <strong><?= Html::encode($this->title) ?></strong>
                <?= Html::a('Create User', ['create'], ['class' => 'btn btn-sm btn-rounded btn-info pull-right']) ?>
            </div>

            <div class="card-body">
                <?php Pjax::begin(['timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'post']]); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'user_id',
                            'value' => 'user.username'
                        ],
                        [
                            'attribute' => 'pack_id',
                            'value' => 'pack.name'
                        ],
                        [
                            'attribute' => 'referrer',
                            'value' => 'referrer0.username'
                        ],
                        [
                            'attribute' => 'position',
                            'filter' => ['Left' => 'Left', 'Right' => 'Right']
                        ],
                        [
                            'attribute' => 'placement',
                            'value' => 'placement0.username'
                        ],
                        [
                            'attribute' => 'place_position',
                            'filter' => ['Left' => 'Left', 'Right' => 'Right']
                        ],
                        'dob:date',
                        'updated_at:datetime',
                        [
                            'header' => 'Payment Mode <br><span class="icon-power_input"></span><br> Status',
                            'format' => 'raw',
                            'value' => function($model) {
                                $userPack=TPHelper::userPack($model->user_id, true);
                                return ($userPack) ? $userPack->payment_mode.' <br><span class="icon-power_input"></span><br> '.$userPack->payment_status : '---';
                            }
                        ],
                       
                    ],
                ]);
                ?>
                <?php Pjax::end(); ?>
            </div>

        </div>
    </div>
</div>