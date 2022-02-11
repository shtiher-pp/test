<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/** @var $param array */
/** @var $status array */
/** @var $services array */
/** @var $totalCount array */
/** @var $mode array */
/** @var $orders array */

?>
<table class="table order-table">
    <thead>
    <tr>
        <th><?= Yii::t('common', 'ID') ?></th>
        <th><?= Yii::t('common', 'User') ?></th>
        <th><?= Yii::t('common', 'Link') ?></th>
        <th><?= Yii::t('common', 'Quantity') ?></th>
        <th class="dropdown-th">
            <div class="dropdown">
                <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <?= Yii::t('common', 'Service') ?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li class="active"><a href="<?= Url::to(['/orders/orders']).'?'.http_build_query(array_merge($param, ["service"=>'']))?>"><?= Yii::t('common', 'All') ?> (<?= $totalCount ?>)</a></li>
                    <?php foreach ($services as $service): ?>
                        <li><a href="<?= Url::to(['/orders/orders']).'?'.http_build_query(array_merge($param, ["service"=>$service['service_id']])) ?>"><span class="label-id"><?=$service['service_count']?></span> <?= Yii::t('common', $service['service'])?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </th>
        <th><?= Yii::t('common', 'Status') ?></th>
        <th class="dropdown-th">
            <div class="dropdown">
                <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <?= Yii::t('common', 'Mode') ?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li class="active"><a href="<?=Url::to(['/orders/orders']).'?'.http_build_query(array_merge($param, ["mode"=>'']))?>"><?= Yii::t('common', 'All') ?></a></li>
                    <li><a href="<?= Url::to(['/orders/orders']).'?'.http_build_query(array_merge($param, ["mode"=>0]))?>"><?=$mode[0]?></a></li>
                    <li><a href="<?= Url::to(['/orders/orders']).'?'.http_build_query(array_merge($param, ["mode"=>1]))?>"><?=$mode[1]?></a></li>
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
            <td><?= $status[$order['status']] ?></td>
            <td><?= !$order['mode'] ? Yii::t('common', $mode[0]) : Yii::t('common', $mode[1]) ?></td>
            <td><span class="nowrap"><?= date('Y-m-d',$order['created']) ?></span><span class="nowrap"><?= date('H:i:s',$order['created']) ?></span></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>