<?php

use yii\helpers\Html;
use common\components\TPHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\Profile */

$this->title = 'Sponsor';
$this->params['breadcrumbs'][] = ['label' => 'Organization', 'url' => ['genealogy']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <strong><?= Html::encode($this->title) ?></strong>
            </div>
            <div class="card-body">
                <div class="container gtree">
                    <?= TPHelper::sponsorTree() ?>
                </div>
            </div>
        </div>
    </div>
</div>