<?php

use yii\widgets\Menu;

/** @var $servicesMenu array */
/** @var $headers array */

?>
<div class="dropdown">
    <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        <?= $headers['service_id'] ?>
        <span class="caret"></span>
    </button>
    <?= Menu::widget([
        'items' => $servicesMenu,
        'encodeLabels' => false,
        'firstItemCssClass' => 'active',
        'options' => [
            'aria-labelledby' => 'dropdownMenu1',
            'class' => 'dropdown-menu',
        ],
    ]) ?>
</div>