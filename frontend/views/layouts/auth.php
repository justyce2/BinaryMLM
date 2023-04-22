<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AuthAsset;
use common\components\TPHelper;

AuthAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= TPHelper::getOption('company_name').': '.Html::encode($this->title) ?></title>
    <link rel="icon" type="image/png" href="<?= Url::to(['img/favicon.ico']) ?>">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

    <div class="container">
        <?= $content ?>
    </div>
    
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
