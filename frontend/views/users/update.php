<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Profile */

if(Yii::$app->user->identity->user_role===2) {
    $this->title = 'Update User: ' . $model->first_name;
    $this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->first_name, 'url' => ['view', 'id' => $model->id]];
    $this->params['breadcrumbs'][] = 'Update';
}
else {
    $this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['profile']];
    $this->params['breadcrumbs'][] = 'Edit Profile';
}
?>
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header"><strong><?= Html::encode($this->title) ?></strong><div><strong>Update  your Profile your will be redirected to complete Your payment if you are yet to pay.</strong></div>
           </div>
            
              
             
           
            <div class="card-body">

                <?= $this->render('_form', [
                    'model' => $model,
                    'user' => $user
                ]) ?>

            </div>
        </div>
    </div>
</div>
