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
                <?= Html::a('Update Payout', ['updatepayout'], ['class' => 'btn btn-sm btn-rounded btn-danger pull-right']) ?>
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
                            'header' => 'User ID',
                            'value' => 'user.id'
                          
                        ],
                         [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Login',
                            'template' => '{completetrans}',
                            'buttons' => [
                                'completetrans' => function($url, $model) {
                                    $userPack=TPHelper::userInfo($model->user_id);
                                    if($userPack) {
                                        
                                        $chqBtn=Html::a('<span class="">login</span>', ['users/login', 'username' => $userPack->username], ['title' => 'Approve Payment']);
                                       // return $userPack->payment_mode==='Paypal' ? $paypalBtn : ($userPack->payment_mode==='Cheque' ? $chqBtn : '');
                                         return  $chqBtn;
                                    }
                                }
                            ],
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
                        //'dob:date',
                        'updated_at:datetime',
                        [
                            'attribute' => 'state',
                            'filter' => 
['2647'=>'Abia
','2648'=>'Abuja Federal Capital Territor
','2649'=>'Adamawa
','2650'=>'Akwa Ibom
','2651'=>'Anambra
','2652'=>'Bauchi
','2653'=>'Bayelsa
','2654'=>'Benue
','2655'=>'Borno
','2656'=>'Cross River
','2657'=>'Delta
','2658'=>'Ebonyi
','2659'=>'Edo
','2660'=>'Ekiti
','2661'=>'Enugu
','2662'=>'Gombe
','2663'=>'Imo
','2664'=>'Jigawa
','2665'=>'Kaduna
','2666'=>'Kano
','2667'=>'Katsina
','2668'=>'Kebbi
','2669'=>'Kogi
','2670'=>'Kwara
','2671'=>'Lagos'],

                            'value' => 'state0.name'
                        ],
                     
                     [
                          'class' => 'yii\grid\ActionColumn',
                            'header' => 'Verify Futterpayment',
                            'template' => '{completetrans}',
                            'buttons' => [
                                'completetrans' => function($url, $model) {
                                    $userPack=TPHelper::userPack($model->user_id);
                                    if($userPack && $userPack->payment_mode === 'Flutterwave' && $userPack->payment_status==='Pending') {
                                        
                                        $chqBtn=Html::a('<span class="">Verify</span>', ['users/verifyflutter', 'txnref' => $userPack->transaction_ref], ['title' => 'Approve Payment']);
                                       // return $userPack->payment_mode==='Paypal' ? $paypalBtn : ($userPack->payment_mode==='Cheque' ? $chqBtn : '');
                                         return  $chqBtn;
                                    }
                                }
                            ],
                           ],
                        
                        [
                            'header' => 'Payment Mode <br><span class="icon-power_input"></span><br> Status',
                            'format' => 'raw',
                            'value' => function($model) {
                                $userPack=TPHelper::userPack($model->user_id, true);
                                return ($userPack) ? $userPack->payment_mode.' <br><span class="icon-power_input"></span><br> '.$userPack->payment_status : '---';
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Action',
                            'template' => '{view} {update} {completetrans}',
                            'buttons' => [
                                'completetrans' => function($url, $model) {
                                    $userPack=TPHelper::userPack($model->user_id);
                                    if($userPack) {
                                        $paypalBtn=Html::a('<span class="icon-credit-card"></span>', ['users/completetrans'], ['title' => 'Complete Payment', 'data' => ['confirm' => 'Are you sure to proceed?', 'method' => 'post', 'params' => ['upack_id' => $userPack->id]]]);
                                        $chqBtn=Html::a('<span class="icon-beenhere"></span>', ['users/approvechq', 'id' => $userPack->id], ['title' => 'Approve Payment', 'data' => ['confirm' => 'Are you sure to proceed?']]);
                                       // return $userPack->payment_mode==='Paypal' ? $paypalBtn : ($userPack->payment_mode==='Cheque' ? $chqBtn : '');
                                         return $userPack->payment_mode==='Cash' ? $chqBtn : ($userPack->payment_mode==='Bank' ? $chqBtn : '');
                                    }
                                }
                            ],
                        ],
                    ],
                ]);
                ?>
                <?php Pjax::end(); ?>
            </div>

        </div>
    </div>
</div>