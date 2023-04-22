<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Messages */

$this->title = $model->subject;
$this->params['breadcrumbs'][] = ['label' => 'Messages', 'url' => ['index']];
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
                        'message:ntext',
                    ],
                ]) ?>
               <?php if(!Yii::$app->request->get('ajax')) { ?>
                <div class="form-group text-center">
                    <?= Html::a('Go Back', ['index'], ['class' => 'btn btn-danger']) ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
