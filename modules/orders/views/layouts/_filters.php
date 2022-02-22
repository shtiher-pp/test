<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/** @var $statuses array */
/** @var $param array */
/** @var $search array */

?>

<ul class="nav nav-tabs p-b">
    <li <?= !isset($param['status']) ? 'class="active"' : '' ?>>
        <?= Html::a(Yii::t('common', 'All orders'), ['/orders']) ?>
    </li>
    <?php foreach ($statuses as $status_id => $status) : ?>
        <li <?= isset($param['status']) ? ($param['status'] ==  $status_id ? 'class="active"' : '' ) : '' ?> >
            <?= Html::a($status, ['/orders', 'status' => $status_id]) ?>
        </li>
    <?php endforeach; ?>
    <li class="pull-right custom-search">
        <?php $form = ActiveForm::begin([
            'method' => 'get',
            'action' => ['/orders'],
            'options' => ['class' => 'form-inline'],
        ]) ?>
        <div class="input-group">
            <?= isset($param['status'])
                ? Html::tag('input', '', ['type' => 'hidden', 'name' => 'status', 'value' => $param['status']])
                : ''  ?>
            <?=Html::tag('input','',['type' => 'text',
                'name' => 'search',
                'class' => 'form-control',
                'placeholder' =>  Yii::t('common', 'Search orders'),
                'value' => isset($param['search']) ? $param['search'] : ''
            ]) ?>
            <span class="input-group-btn search-select-wrap">
            <?= Html::dropDownList('searchType', isset($param['searchType']) ? $param['searchType'] : 1, $search, ['class' => 'form-control search-select']) ?>
            <button type="submit" class="btn btn-default">
                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            </button>
            </span>
        </div>
        <?php ActiveForm::end() ?>
    </li>
</ul>