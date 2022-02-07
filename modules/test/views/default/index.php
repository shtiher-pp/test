<?php
use yii\widgets\LinkPager;
use yii\helpers\Url;
?>

<div style="
    padding-top: 60px;
"></div>
<div class="container-fluid">
  <ul class="nav nav-tabs p-b">
    <li <?= !isset($_GET['status'])? 'class="active"' : '' ?>><a href="<?=Url::to(['/test/default'])?>"><?=Yii::t('common', 'All orders') ?></a></li>
    <li <?= isset($_GET['status']) ? ($_GET['status']==0? 'class="active"':'' ): '' ?> ><a href="<?=Url::to(['/test/default', 'status' => 0])?>"><?=Yii::t('common', $status[0]) ?></a></li>
    <li <?= isset($_GET['status']) ? ($_GET['status']==1? 'class="active"':'' ): '' ?>><a href="<?=Url::to(['/test/default', 'status' => 1])?>"><?=Yii::t('common', $status[1]) ?></a></li>
    <li <?= isset($_GET['status']) ? ($_GET['status']==2? 'class="active"':'' ): '' ?>><a href="<?=Url::to(['/test/default', 'status' => 2])?>"><?=Yii::t('common', $status[2]) ?></a></li>
    <li <?= isset($_GET['status']) ? ($_GET['status']==3? 'class="active"':'' ): '' ?>><a href="<?=Url::to(['/test/default', 'status' => 3])?>"><?=Yii::t('common', $status[3]) ?></a></li>
    <li <?= isset($_GET['status']) ? ($_GET['status']==4? 'class="active"':'' ): '' ?>><a href="<?=Url::to(['/test/default', 'status' => 4])?>"><?=Yii::t('common', $status[4]) ?></a></li>
    <li class="pull-right custom-search">
      <form class="form-inline" action="<?=Url::to(['/test/default'])?>" method="get">
        <div class="input-group">
            <?= isset($_GET['status']) ? '<input type="hidden" name="status" value="'.$_GET['status'].'">': ''  ?>
          <input type="text" name="search" class="form-control" value="" placeholder="<?=Yii::t('common', 'Search orders') ?>">
          <span class="input-group-btn search-select-wrap">
            <select class="form-control search-select" name="search-type">
              <option value="1" selected=""><?=Yii::t('common', 'Order ID') ?></option>
              <option value="2"><?=Yii::t('common', 'Link') ?></option>
              <option value="3"><?=Yii::t('common', 'Username') ?></option>
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
      <th><?=Yii::t('common', 'ID') ?></th>
      <th><?=Yii::t('common', 'User') ?></th>
      <th><?=Yii::t('common', 'Link') ?></th>
      <th><?=Yii::t('common', 'Quantity') ?></th>
      <th class="dropdown-th">
        <div class="dropdown">
          <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <?=Yii::t('common', 'Service') ?>
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li class="active"><a href="<?=Url::to(['/test/default']).'?'.http_build_query(array_merge($_GET, ["service"=>'']))?>"><?=Yii::t('common', 'All') ?> (<?=$totalCount?>)</a></li>
              <?php foreach ($services as $service): ?>
            <li><a href="<?=Url::to(['/test/default']).'?'.http_build_query(array_merge($_GET, ["service"=>$service['service_id']]))?>"><span class="label-id"><?=$service['service_count']?></span> <?=Yii::t('common', $service['service'])?></a></li>
              <?php endforeach; ?>
          </ul>
        </div>
      </th>
      <th><?=Yii::t('common', 'Status') ?></th>
      <th class="dropdown-th">
        <div class="dropdown">
          <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              <?=Yii::t('common', 'Mode') ?>
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li class="active"><a href="<?=Url::to(['/test/default']).'?'.http_build_query(array_merge($_GET, ["mode"=>'']))?>"><?=Yii::t('common', 'All') ?></a></li>
            <li><a href="<?=Url::to(['/test/default']).'?'.http_build_query(array_merge($_GET, ["mode"=>0]))?>"><?=Yii::t('common', 'Manual') ?></a></li>
            <li><a href="<?=Url::to(['/test/default']).'?'.http_build_query(array_merge($_GET, ["mode"=>1]))?>"><?=Yii::t('common', 'Auto') ?></a></li>
          </ul>
        </div>
      </th>
      <th><?=Yii::t('common', 'Created') ?></th>
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
            <span class="label-id"><?=$order['service_id']?></span><?= Yii::t('common', $order['service']) ?>
        </td>
        <td><?= Yii::t('common', $status[$order['status']]) ?></td>
        <td><?= !$order['mode'] ? Yii::t('common', 'Manual') : Yii::t('common', 'Auto') ?></td>
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
        <div style="padding-right: 50px;">
        <span style="float: right;">
        <a href="<?=Url::to(['/test/export']).'?'.http_build_query(array_merge($_GET))?>"><?=Yii::t('common', Yii::t('common', 'Save result')) ?></a></span>
        </div>
    </div>
</div>
</br>