<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

//var_dump(((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
//var_dump($services);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>test</title>
  <style>
    .label-default{
      border: 1px solid #ddd;
      background: none;
      color: #333;
      min-width: 30px;
      display: inline-block;
    }
  </style>
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
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
        <li class="active"><a href="/test/default/">Orders</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container-fluid">
  <ul class="nav nav-tabs p-b">
    <li <?= !isset($_GET['status'])? 'class="active"' : '' ?>><a href="/test/default/">All orders</a></li>
    <li <?= isset($_GET['status']) ? ($_GET['status']==0? 'class="active"':'' ): '' ?> ><a href="/test/default/index?status=0">Pending</a></li>
    <li <?= isset($_GET['status']) ? ($_GET['status']==1? 'class="active"':'' ): '' ?>><a href="/test/default/index?status=1">In progress</a></li>
    <li <?= isset($_GET['status']) ? ($_GET['status']==2? 'class="active"':'' ): '' ?>><a href="/test/default/index?status=2">Completed</a></li>
    <li <?= isset($_GET['status']) ? ($_GET['status']==3? 'class="active"':'' ): '' ?>><a href="/test/default/index?status=3">Canceled</a></li>
    <li <?= isset($_GET['status']) ? ($_GET['status']==4? 'class="active"':'' ): '' ?>><a href="/test/default/index?status=4">Error</a></li>
    <li class="pull-right custom-search">
      <form class="form-inline" action="<?='/test/default/index?'?>" method="get">
        <div class="input-group">
            <?= isset($_GET['status']) ? '<input type="hidden" name="status" value="'.$_GET['status'].'">': ''  ?>
          <input type="text" name="search" class="form-control" value="" placeholder="Search orders">
          <span class="input-group-btn search-select-wrap">
            <select class="form-control search-select" name="search-type">
              <option value="1" selected="">Order ID</option>
              <option value="2">Link</option>
              <option value="3">Username</option>
            </select>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </span>
        </div>
      </form>
    </li>
  </ul>
  <table class="table order-table">
    <thead>
    <tr>
      <th>ID</th>
      <th>User</th>
      <th>Link</th>
      <th>Quantity</th>
      <th class="dropdown-th">
        <div class="dropdown">
          <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            Service
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li class="active"><a href="<?= 'index?'.http_build_query(array_merge($_GET, ["service"=>'']))?>">All (<?=$totalCount?>)</a></li>
              <?php foreach ($services as $service): ?>
            <li><a href="<?= 'index?'.http_build_query(array_merge($_GET, ["service"=>$service['service_id']]))?>"><span class="label-id"><?=$service['service_count']?></span> <?=$service['service']?></a></li>
              <?php endforeach; ?>
          </ul>
        </div>
      </th>
      <th>Status</th>
      <th class="dropdown-th">
        <div class="dropdown">
          <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            Mode
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li class="active"><a href="<?= 'index?'.http_build_query(array_merge($_GET, ["mode"=>'']))?>">All</a></li>
            <li><a href="<?= 'index?'.http_build_query(array_merge($_GET, ["mode"=>0]))?>">Manual</a></li>
            <li><a href="<?= 'index?'.http_build_query(array_merge($_GET, ["mode"=>1]))?>">Auto</a></li>
          </ul>
        </div>
      </th>
      <th>Created</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($orders as $order): ?>
    <tr>
        <td><?= $order['id'] ?></td>
        <td><?= $order['full_name']?></td>
        <td class="link"><?= $order['link'] ?></td>
        <td><?= $order['quantity'] ?></td>
        <td class="service">
            <span class="label-id"><?=$order['service_id']?></span><?= $order['service'] ?>
        </td>
        <td><?= $order['status'] ?></td>
        <td><?= !$order['mode'] ? 'Manual' : 'Auto' ?></td>
        <td><span class="nowrap"><?= date('Y-m-d',$order['created']) ?></span></br><span class="nowrap"><?= date('H:i:s',$order['created']) ?></span></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
    <div class="row">
        <div class="col-sm-8">
            <?= LinkPager::widget(['pagination' => $pagination]) ?>
        </div>
        <div class="col-sm-4 pagination-counters">
            <?php if (!isset($_GET['page'])&&(!$pagination->totalCount==NULL)&&($pagination->totalCount<$pagination->defaultPageSize)): ?>
                <?= '1' . ' to '. $pagination->totalCount.' of '. $pagination->totalCount ?>
            <?php endif; ?>
            <?php if (!isset($_GET['page'])&&(!$pagination->totalCount==NULL)&&!($pagination->totalCount<$pagination->defaultPageSize)): ?>
                <?= '1' . ' to '. $pagination->defaultPageSize.' of '. $pagination->totalCount ?>
            <?php endif; ?>
            <?php if (isset($_GET['page'])&&$_GET['page']!=ceil($pagination->totalCount/$pagination->defaultPageSize)):?>
                <?= (($_GET['page']-1)*$pagination->defaultPageSize)+1 .' to '. $_GET['page']*$pagination->defaultPageSize.' of '. $pagination->totalCount?>
            <?php endif; ?>
            <?php if (isset($_GET['page'])&&$_GET['page']>1&&$_GET['page']==ceil($pagination->totalCount/$pagination->defaultPageSize)):?>
                <?= (($_GET['page']-1)*$pagination->defaultPageSize)+1 .' to '. $pagination->totalCount .' of '. $pagination->totalCount?>
            <?php endif; ?>
        </div>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
<html>