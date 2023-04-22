<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Super Admin';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">

            <div class="card-header">
                <strong><?= Html::encode($this->title) ?></strong>
                <?= Html::a('Create Superadmin', ['create'], ['class' => 'btn btn-sm btn-rounded btn-info pull-right']) ?>
            </div>

            <div class="card-body">
                <?php Pjax::begin(['timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'post']]); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'username',
                        'email:email',
                        'created_at:datetime',
                        'updated_at:datetime',
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function($model) {
                                $tf=($model->status==1) ? 'Active' : 'Inactive';
                                $to_change=($model->status==1) ? 0 : 1 ;
                                $post_url=Url::to(['superadmin/chstatus']);
                                return (Yii::$app->user->identity->id!=$model->id) ? Html::checkbox('agree', $model->status, ['label' => $tf, 'onclick' => 'change_status("'.$model->id.'", "'.$to_change.'", "'.$post_url.'");', 'title' => 'Click to change status']) : '<i>It\'s You</i>';
                            },
                            'filter' => false,
                        ],

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>