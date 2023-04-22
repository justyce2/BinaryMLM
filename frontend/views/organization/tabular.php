<?php

use yii\helpers\Html;
use execut\widget\TreeView;

$this->title = 'Tabular';
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
                <div class="container">
                    <?=
                    TreeView::widget([
                        'data' => $data,
                        'size' => TreeView::SIZE_MIDDLE,
                        'header' => 'Tabular Tree View',
                        'defaultIcon' => 'icon-user-tie'
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>