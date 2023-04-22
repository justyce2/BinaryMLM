<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Packages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            
            <div class="card-header">
                <strong><?= Html::encode($this->title) ?></strong>
                <?= Html::a('Create Package', ['create'], ['class' => 'btn btn-sm btn-rounded btn-info pull-right']) ?>
            </div>
            
            <div class="card-body">
                <?php Pjax::begin(['timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'post']]); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        
                        'name',
                        'amount:currency',
                        'point_volume',
                        'updated_at:datetime',
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function($model) {
                                $tf=($model->status=='Active') ? 1 : 0;
                                $to_change=($model->status=='Active') ? 'Inactive' : 'Active';
                                $post_url=Url::to(['package/chstatus']);
                                return Html::checkbox('agree', $tf, ['label' => $model->status, 'onclick' => 'change_status("'.$model->id.'", "'.$to_change.'", "'.$post_url.'");', 'title' => 'Click to change status']);
                            },
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Action',
                            'template' => '{update} {delete}'
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>

        </div>
    </div>
</div>
