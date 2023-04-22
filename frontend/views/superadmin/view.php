<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Super Admin', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <strong><?= Html::encode($this->title) ?></strong>
                <?php if(!Yii::$app->request->get('ajax')) { ?>
                <?= Html::a('Go Back', ['index'], ['class' => 'btn btn-sm btn-rounded btn-danger pull-right']) ?>
                <?php } ?>
            </div>
            <div class="card-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'username',
                        'email:email',
                        [
                            'label' => 'Current Balance',
                            'format' => 'currency',
                            'value' => function($model) {
                                return common\components\TPHelper::curBalance($model->id);
                            }
                        ],
                        'created_at:datetime',
                        'updated_at:datetime',
                    ],
                ]) ?>
                <?php if(!Yii::$app->request->get('ajax')) { ?>
                <div class="form-group text-center">
                    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
                    <?= Html::a('Go Back', ['index'], ['class' => 'btn btn-danger']) ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
