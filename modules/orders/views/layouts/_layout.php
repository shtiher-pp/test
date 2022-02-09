<?php

/* @var $this \yii\web\View */
/* @var $content string */
/** @var $orders array */
/** @var $services array */
/** @var $pagination array */
/** @var $totalCount string */
/** @var $status array */
/** @var $mode array */
/** @var $pages array */
/** @var $param array */


use app\assets\OrdersAsset;
use yii\bootstrap4\Html;
use yii\helpers\Url;

OrdersAsset::register($this);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <title></title>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<?php $this->beginBody() ?>
<header>
    <nav class="navbar navbar-fixed-top navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="bs-navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="<?=Url::to(['/orders/orders'])?>"><?=Yii::t('common', 'Orders') ?></a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<?= $content ?>

</body>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>
