<?php

namespace app\modules\orders\widgets;

use app\modules\orders\models\models\Orders;
use Yii;
use yii\helpers\Url;
use app\modules\orders\widgets\CustomFilter;

class ModeFilter extends CustomFilter
{
    /**
     * @return array
     */
    public function getMenu(): array
    {
        $modeMenu = [['label' => Yii::t('common', 'All'), 'url' => [Url::current(["mode" => null])]]];
        foreach (Orders::getMode() as $key => $value) {
            $modeMenu[] = ['label' => $value, 'url' => [Url::current(["mode" => $key])]];
        }
        return $modeMenu;
    }
}