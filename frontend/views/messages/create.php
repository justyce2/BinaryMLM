<?php
use yii\helpers\Html;

$this->title = 'Compose Message';
$this->params['breadcrumbs'][] = ['label' => 'Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header"><strong><?= Html::encode($this->title) ?></strong></div>
            <div class="card-body">

                <?= $this->render('_form', [
                    'model' => $model
                ]) ?>

            </div>
        </div>
    </div>
</div>
