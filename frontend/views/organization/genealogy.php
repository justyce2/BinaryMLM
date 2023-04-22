<?php

use yii\helpers\Html;
use common\components\TPHelper;
use frontend\models\UserPackage;
use frontend\models\Profile;

/* @var $this yii\web\View */

$this->title = 'Genealogy';
$this->params['breadcrumbs'][] = ['label' => 'Organization', 'url' => ['genealogy']];
$this->params['breadcrumbs'][] = $this->title;



?>
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <strong><?= Html::encode($this->title) ?></strong>
                <?= !empty($startFrom) ? Html::a('Reset Genealogy', ['genealogy'], ['class' => 'btn btn-sm btn-rounded btn-danger pull-right']) :''; ?>
            </div>
            <div class="card-body">
                <div class="container gtree">  <?php 
                $upack = Yii::$app->user->identity->id ;
 $pInf = Profile::findOne(['placement'=>Yii::$app->user->identity->id]);
 if($pInf){
$upk = UserPackage::findOne(['user_id'=>$pInf->user_id, 'payment_status'=>'Paid']);
               echo "<a  class='btn btn-sm btn-rounded btn-danger' href='https://istandwithjesus.org.ng/mem/users/approvechq?id=$upk->id'>Click HERE if the TREE below is not correct</a>";
 }
                ?>
                    <?php
                    $startFrom=!empty($startFrom) ? $startFrom : ((Yii::$app->user->identity->user_role===2) ? TPHelper::firstUser() : Yii::$app->user->identity->id );
                   // print_r($startFrom);
                    echo TPHelper::dispTree($startFrom);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>