<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Profile */

$this->title = 'My Profile';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <strong><?= Html::encode($this->title) ?></strong>
                <?php if(!Yii::$app->request->get('ajax')) { ?>
                <?= Html::a('Edit Profile', ['edit'], ['class' => 'btn btn-sm btn-rounded btn-danger pull-right']) ?>
                <?php } ?>
            </div>
            <div class="card-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'label' => 'Full Name',
                            'value' => function($model) {
                                return ucwords($model->first_name.' '.$model->last_name);
                            }
                        ],
                        [
                            'attribute' => 'username',
                            'value' => function($model) {
                                return $model->user->username;
                            }
                        ],
                        [
                            'label' => 'Email Address',
                            'value' => function($model) {
                                return $model->user->email;
                            }
                        ],
                        [
                            'attribute' => 'level',
                            'value' => function($model) {
                                return $model->pack->name;
                            }
                        ],
                        [
                            'attribute' => 'referrer',
                            'value' => function($model) {
                                return $model->referrer0->username;
                            }
                        ],
                        'gender',
                        'dob:date',
                        [
                            'attribute' => 'address_line_1',
                            'value' => function($data) { return ($data->address_line_1) ? $data->address_line_1 : '---'; },
                            'visible' => !Yii::$app->request->get('ajax'),
                        ],
                        [
                            'attribute' => 'address_line_2',
                            'value' => function($data) { return ($data->address_line_2) ? $data->address_line_2 : '---'; },
                            'visible' => !Yii::$app->request->get('ajax'),
                        ],
                        [
                            'attribute' => 'city',
                            'value' => function($model) {
                                return ($model->city) ? $model->city0->name : '---';
                            },
                            'visible' => !Yii::$app->request->get('ajax'),
                        ],
                        [
                            'attribute' => 'state',
                            'value' => function($model) {
                                return ($model->state) ? $model->state0->name : '---';
                            },
                            'visible' => !Yii::$app->request->get('ajax'),
                        ],
                        [
                            'attribute' => 'country',
                            'value' => function($model) {
                                return ($model->country) ? $model->country0->name: '---';
                            }
                        ],
                        [
                            'attribute' => 'zip_code',
                            'visible' => !Yii::$app->request->get('ajax'),
                        ],
                        'mobile_no',
                        [
                            'attribute' => 'landline_no',
                            'value' => function($data) { return ($data->landline_no) ? $data->landline_no : '---'; },
                            'visible' => !Yii::$app->request->get('ajax'),
                        ],
                        [
                            'attribute' => 'facebook',
                            'value' => function($data) { return ($data->facebook) ? $data->facebook : '---'; },
                            'visible' => !Yii::$app->request->get('ajax'),
                        ],
                        [
                            'attribute' => 'twitter',
                            'value' => function($data) { return ($data->twitter) ? $data->twitter : '---'; },
                            'visible' => !Yii::$app->request->get('ajax'),
                        ],
                        [
                            'attribute' => 'blockchain_address',
                            'value' => function($data) { return ($data->blockchain_address) ? $data->blockchain_address : '---'; },
                            'visible' => !Yii::$app->request->get('ajax'),
                        ],
                        'created_at:datetime',
                        'updated_at:datetime',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>