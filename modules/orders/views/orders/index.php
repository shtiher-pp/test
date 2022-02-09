<?php

use yii\helpers\Url;

/** @var $param array */

$param = $this->params['params']['param'];

?>

<div style="padding-right: 50px;">
        <span style="float: right;">
        <a href="<?=Url::to(['/orders/export']).'?'.http_build_query(array_merge($param))?>"><?=Yii::t('common', Yii::t('common', 'Save result')) ?></a></span>
</div>
</div>
</div>
</br>