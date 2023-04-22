<?php
use yii\bootstrap\Html;
use yii\helpers\Url;
use scotthuangzl\googlechart\GoogleChart;
use common\components\DboardHelper;
use supplyhog\ClipboardJs\ClipboardJsWidget;

$this->title = (Yii::$app->user->identity->user_role===2) ? 'Statistics and Quick Overview' : 'User Home-  Current Level: '.DboardHelper::levelget();
$this->params['breadcrumbs'][] = $this->title;
$spons = Yii::$app->user->identity->id;
$refUrl=Url::to(['site/register', 'ref' => Yii::$app->user->identity->username], true);
?>
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="stats-widget">
                   
                    <div class="stats-widget-body">
                        <ul class="row no-gutters">
                            
                            <li class="">
                                <h4 class="total"> <?php
                                if( DboardHelper::levelgetid() >0 && DboardHelper::levelgetid() < 2){
                                    
                                    echo("You are in the ENTRY Stage");
                                }else if(DboardHelper::levelgetid() >2 && DboardHelper::levelgetid() < 7){
                                    echo("You are in the LEADERSHIP Stage");
                                }else if(DboardHelper::levelgetid() >7 && DboardHelper::levelgetid() < 10){
                                    echo("You are in the PILGRIM SQUAD");
                                        
                                    }else{
                                       echo("You are an Admin");  
                                       //echo(Yii::$app->session->get('pack_id'));
                                     
                                    }
                                
                                ?></h4>
                            </li>
                        </ul>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
<div class="row gutters">
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="stats-widget">
                    <div class="stats-widget-header">
                        <i class="icon-tree"></i>
                    </div>
                    <div class="stats-widget-body">
                        <ul class="row no-gutters">
                            <li class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col">
                                <h6 class="title">Level</h6> 
                            </li>
                            <li class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col">
                                <h4 class="total"><?= DboardHelper::levelget() ?></h4>
                            </li>
                        </ul>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="stats-widget">
                    <div class="stats-widget-header">
                        <i class="icon-coin-dollar"></i>
                    </div>
                    <div class="stats-widget-body">
                        <ul class="row no-gutters">
                            <li class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col">
                                <h6 class="title">Ewallet</h6> 
                            </li>
                            <li class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col">
                                <h4 class="total"><?= DboardHelper::ewallet() ?></h4>
                            </li>
                        </ul>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="stats-widget">
                    <div class="stats-widget-header">
                        <i class="icon-stats-bars"></i>
                    </div>
                    <div class="stats-widget-body">
                        <!-- Row start -->
                        <ul class="row no-gutters">
                            <li class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col">
                                <h6 class="title"><?= (Yii::$app->user->identity->user_role===2) ? 'Sales' : 'Spent' ?></h6>
                            </li>
                            <li class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col">
                                <h4 class="total"><?= DboardHelper::sales() ?></h4>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="stats-widget">
                    <div class="stats-widget-header">
                        <i class="icon-credit-card"></i>
                    </div>
                    <div class="stats-widget-body">
                        <!-- Row start -->
                        <ul class="row no-gutters">
                            <li class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col">
                                <h6 class="title">Payout Release</h6>
                            </li>
                            <li class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col">
                                <h4 class="total"><?= DboardHelper::payout() ?></h4>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="stats-widget">
                    <div class="stats-widget-header">
                        <i class="icon-bubbles2"></i>
                    </div>
                    <div class="stats-widget-body">
                        <!-- Row start -->
                        <ul class="row no-gutters">
                            <li class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col">
                                <h6 class="title">Messages</h6>
                            </li>
                            <li class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col">
                                <h4 class="total"><?= DboardHelper::messages() ?></h4>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row gutters">
    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
        <div class="card">

            <div class="card-header">
                <strong><?= (Yii::$app->user->identity->user_role===2) ? 'Total Earnings' : 'My Earnings' ?></strong>
            </div>

            <div class="card-body">
                <?=
                GoogleChart::widget([
                    'visualization' => 'AreaChart',
                    'data' => (Yii::$app->user->identity->user_role===2) ? DboardHelper::earningsData() : DboardHelper::userEarnings(),
                    'options' => [
                        'titleTextStyle' => ['color' => '#ff0000'],
                        'backgroundColor' => ['fill' => 'transparent'],
                    ]
                ]);
                ?>
            </div>

        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
        <div class="card">

            <div class="card-header">
                <strong>Promotion Tools</strong>
            </div>

            <div class="card-body">
                <div class="text-muted fs14">Share your referral url and earn much more. <br><br> You can use below url to sponsor users under your downline. It will help you to earn more.</div><br>
                <p> SPONSOR ID: <?=$spons?></p>
                <div class="input-group mb-3">
                  <?= Html::textInput('refUrl', $refUrl, ['class' => 'form-control', 'id' => 'refUrl']) ?>
                  <div class="input-group-append">
                    <?= ClipboardJsWidget::widget([
                    'inputId' => "#refUrl",
                    'label' => 'Copy',
                    'htmlOptions' => ['class' => 'btn-sm btn-info']
                ]) ?>
                  </div>
                </div>
                <div class="social-share">
                    <?= Html::a('<i class="icon-social-facebook-circular"></i>', 'http://www.facebook.com/sharer.php?u='.$refUrl, ['title' => 'Share on Facebook', 'target' => '_blank']) ?>
                    <?= Html::a('<i class="icon-social-twitter-circular"></i>', 'https://twitter.com/share?url='.$refUrl.'&amp;text=Join%20And%20Earn&amp;hashtags=techplait', ['title' => 'Share on Twitter', 'target' => '_blank']) ?>
                    <?= Html::a('<i class="icon-social-linkedin-circular"></i>', 'http://www.linkedin.com/shareArticle?mini=true&amp;url='.$refUrl, ['title' => 'Share on Linkedin', 'target' => '_blank']) ?>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">

            <div class="card-header">
                <strong>Statistics</strong>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                        <?=
                        GoogleChart::widget([
                            'visualization' => 'PieChart',
                            'data' => DboardHelper::piechartData(),
                            'options' => [
                                'title' => (Yii::$app->user->identity->user_role===2) ? 'Total users' : 'Referred users',
                                'titleTextStyle' => ['color' => '#ff0000'],
                                'backgroundColor' => ['fill' => 'transparent']
                            ]
                        ]);
                        ?>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                        <?=
                        GoogleChart::widget([
                            'visualization' => 'BarChart',
                            'data' => DboardHelper::userschartData(),
                            'options' => [
                                'title' => (Yii::$app->user->identity->user_role===2) ? 'Users joined in this month' : 'Referred users in this month',
                                'titleTextStyle' => ['color' => '#ff0000'],
                                'backgroundColor' => ['fill' => 'transparent']
                            ]
                        ]);
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>