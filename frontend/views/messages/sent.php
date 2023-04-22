<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\components\TPHelper;

$this->title = 'Sent Messages';
$this->params['breadcrumbs'][] = ['label' => 'Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header"><strong><?= Html::encode($this->title) ?></strong></div>
            <div class="card-body">

                <div class="container"><br>
                    <div class="row">
                        <div class="col-sm-3 col-md-2">
                            <a href="<?= Url::to(['messages/create']) ?>" class="btn btn-danger btn-sm btn-block"><span class="icon-edit"></span> Compose</a><hr>
                            <ul class="nav nav-pills nav-stacked d-block">
                                <li class="nav-item"><a class="nav-link blue_text" href="<?= Url::to(['messages/index']) ?>">Inbox <?= TPHelper::unreadBadge(); ?></a></li>
                                <li class="nav-item"><a class="nav-link blue_text active" href="<?= Url::to(['messages/sent']) ?>">Sent</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-9 col-md-10">
                            <strong><?= Html::encode($this->title) ?></strong><hr>
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => false,
                                'layout' => '{items} {pager}',
                                'columns' => [
                                    [
                                        'attribute' => 'msg_from',
                                        'format' => 'raw',
                                        'value' => function($model) {
                                            return Html::a($model->msgTo->username, ['messages/view', 'id' => $model->id, 'ajax' => true], ['target' => '_blank', 'title' => 'View Message', 'data-pjax' => 0, 'onclick' => 'return loadModal(this)', 'class' => 'blue_text']);
                                        }
                                    ],
                                    'subject',
                                    [
                                        'attribute' => 'date',
                                        'value' => function($model) {
                                            return date('d M, h:i A', $model->date);
                                        }
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'template' => '{delmsg}',
                                        'buttons' => [
                                            'delmsg' => function($url, $model) {
                                                return Html::a('<span class="tpicon icon-trash"></span>', ['messages/delete', 'id' => $model->id, 'from' => 'sent'], [
                                                    'data-method' => 'post',
                                                    'data-confirm' => 'Sure to delete?'
                                                ]);
                                            }
                                        ],
                                    ],
                                ],
                            ]); ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('thead{ display: none; }');
$inlineScript=<<<JS
$('#TPModal').on('hidden.bs.modal', function () {
    location.reload();
});
JS;

$this->registerJs($inlineScript);?>