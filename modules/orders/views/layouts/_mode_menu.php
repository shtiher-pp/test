<?php

use yii\widgets\Menu;

/** @var $modeMenu array */
/** @var $headers array */

?>
<div class="dropdown">
    <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        <?= $headers['mode'] ?>
        <span class="caret"></span>
    </button>
    <?= Menu::widget([
        'items' => $modeMenu,
        'firstItemCssClass' => 'active',
        'options' => [
            'aria-labelledby' =>'dropdownMenu1',
            'class' => 'dropdown-menu',
        ],
    ]) ?>
</div>