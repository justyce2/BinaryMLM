<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\components\DboardHelper;
use common\components\TPHelper;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?>: <?= TPHelper::getOption('company_name') ?></title>
    <link rel="icon" type="image/png" href="<?= Url::to(['img/favicon.ico']) ?>">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    
    <!-- BEGIN .app-wrap -->
    <div class="app-wrap">
        <!-- BEGIN .app-heading -->
        <header class="app-header">
            <div class="container-fluid">
                <div class="row gutters">
                    <div class="col-xl-7 col-lg-7 col-md-6 col-sm-7 col-4">
                        <a class="mini-nav-btn" href="#" id="app-side-mini-toggler">
                            <i class="icon-chevron-thin-left"></i>
                        </a>
                        <a href="#app-side" data-toggle="onoffcanvas" class="onoffcanvas-toggler" aria-expanded="true">
                            <i class="icon-chevron-thin-left"></i>
                        </a>
                        <!-- Live updates start -->
                        <div class="live-updates">
                            <ul class="header-news" id="header-news">
                                <?php
                                $latest=DboardHelper::latestActivities();
                                foreach($latest as $lt) {
                                $actuname=(Yii::$app->user->identity->id===$lt->user_id) ? 'You' : $lt->user->username;
                                ?>
                                <li>
                                    <a href="javascript:void(0)">
                                        <i class="icon-bell2"></i>
                                        <span><?= ucfirst(strtolower($actuname.' '.$lt->text.' on '.Yii::$app->formatter->format($lt->date, 'datetime'))) ?></span>
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <!-- Live updates end -->
                    </div>
                    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-5 col-4">
                        <ul class="header-actions">
                            <li class="dropdown">
                                <a href="#" id="userSettings" class="user-settings"  style="padding: 19px 18px;" data-toggle="dropdown" aria-haspopup="true">
                                    <i class="icon-account_circle avatar"></i>
                                    <span class="user-name"><?= DboardHelper::displayName() ?></span>
                                    <i class="icon-chevron-small-down"></i>
                                </a>
                                <div class="dropdown-menu lg dropdown-menu-right" aria-labelledby="userSettings">
                                    <ul class="user-settings-list">
                                        <li>
                                            <a href="<?= Url::to((Yii::$app->user->identity->user_role===2) ? ['settings/company'] : ['users/profile']) ?>">
                                                <div class="icon">
                                                    <i class="icon-account_circle"></i>
                                                </div>
                                                <p>Profile</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= Url::to(['users/transpass']) ?>">
                                                <div class="icon red">
                                                    <i class="icon-cog3"></i>
                                                </div>
                                                <p>Settings</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= Url::to(['activity/index']) ?>">
                                                <div class="icon yellow">
                                                    <i class="icon-schedule"></i>
                                                </div>
                                                <p>Activity</p>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="logout-btn">
                                        <?= Html::a('Logout', ['site/logout'], ['class' => 'btn btn-primary', 'data' => ['method' => 'post']]) ?>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <!-- END: .app-heading -->
        
        <!-- BEGIN .app-container -->
        <div class="app-container">
            
            <?= $this->render('leftmenu'); ?>
            
            <!-- BEGIN .app-main -->
            <div class="app-main">
                <!-- BEGIN .main-heading -->
                <header class="main-heading">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <?= Breadcrumbs::widget([
                                    'itemTemplate' => "<li class='breadcrumb-item'>{link}</li>\n",
                                    'activeItemTemplate' => "<li class='breadcrumb-item active'>{link}</li>\n",
                                    'homeLink' => [ 
                                        'label' => 'Dashboard',
                                        'url' => Yii::$app->homeUrl,
                                    ],
                                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                ]) ?>
                            </div>
                        </div>
                    </div>
                </header>
                <!-- END: .main-heading -->
                <!-- BEGIN .main-content -->
                <div class="main-content">
                    <?= $content ?>
                </div>
                <!-- END: .main-content -->
            </div>
            <!-- END: .app-main -->
        </div>
        <!-- END: .app-container -->
    </div>
    <!-- END: .app-wrap -->
    
    <!-- Modal -->
    <div class="modal fade" id="TPModal" tabindex="-1" role="dialog" aria-labelledby="TPModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="TPModalLabel">Techplait</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="TPModalContent"></div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function loadModal(obj) {
            $('#TPModalLabel').html(obj.title);
            $('#TPModalContent').load(obj.href);
            $("#TPModal").modal();
            return false;
        }
    </script>
    
    <div id="messages"></div>
    <?php
    $this->registerJs("var messages = $('#messages').notify({removeIcon: '<i class=\'icon-times\'></i>'});");
    common\components\MLMHelper::flashCache();
    if(Yii::$app->session->hasFlash('success')) {
        $respMsg=Yii::$app->session->getFlash('success');
        $this->registerJs("messages.show('$respMsg', {
		type: 'success',
		title: 'Great!',
	});");
    }
    if(Yii::$app->session->hasFlash('error')) {
        $respMsg=Yii::$app->session->getFlash('error');
        $this->registerJs("messages.show('$respMsg', {
		type: 'danger',
		title: 'Oops!',
	});");
    }
    ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>