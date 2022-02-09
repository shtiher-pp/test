<?php

/* @var $this \yii\web\View */
/* @var $content string */

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
    <style>
        .label-default{
            border: 1px solid #ddd;
            background: none;
            color: #333;
            min-width: 30px;
            display: inline-block;
        }
        .label-id {
            border: 1px solid #ddd;
            background: none;
            min-width: 30px;
            display: inline-block;
            padding: 0.2em 0.6em 0.3em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: 1px;
            border-radius: 0.25em;
        }
    </style>
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
<?php $this->beginContent('@app/modules/orders/views/layouts/_filters.php'); ?>
<?= $content ?>
<?php $this->endContent(); ?>
<?php $this->beginContent('@app/modules/orders/views/layouts/_order_list.php'); ?>
<?= $content ?>
<?php $this->endContent(); ?>
<?php $this->beginContent('@app/modules/orders/views/layouts/_pagination.php'); ?>
<?= $content ?>
<?php $this->endContent(); ?>
<?= $content ?>
</body>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>
