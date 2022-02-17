<?php

/** @var $statuses array */
/** @var $param array */
/** @var $search array */
/** @var $orders array */
/** @var $headers array */

use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php if (isset($param['error'])): ?>
    <div class="alert alert-danger" role="alert">
        <?php foreach ($param['error'] as $key => $error): ?>
            <p><?= $key.': '.$error[0] ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<div class="container-fluid">
    <?= $this->render('../layouts/_filters', [
        'statuses' => $statuses,
        'param' => $param,
        'search' => $search,
    ]) ?>
    <?= $this->render('../layouts/_order_list', [
        'orders' => $orders,
        'headers' => $headers,
    ]) ?>
    <div class="export-csv-link">
        <span>
            <?= Html::a(Yii::t('common', 'Save result'), Url::to(array_merge(['/orders/export'], $param))) ?>
        </span>
    </div>
</div>
</br>