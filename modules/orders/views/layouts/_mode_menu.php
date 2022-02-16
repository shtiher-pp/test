<?php

use app\modules\orders\widgets\ModeMenu;

/** @var $headers array */

?>
<div class="dropdown">
    <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        <?= $headers['mode'] ?>
        <span class="caret"></span>
    </button>
    <?= ModeMenu::widget(['items' => 'modeMenu']) ?>
</div>