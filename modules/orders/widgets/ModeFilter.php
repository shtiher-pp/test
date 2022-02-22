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
        $modeMenu = [['label' => Yii::t('common', 'All'),
            'url' => [Url::current(["mode" => null])], 'active' => isset($this->param['mode']) ? '' : 'true']];
        foreach (Orders::getMode() as $key => $value) {
            $active = '';
            if ($this->param['mode'] == $key && isset($this->param['mode'])) {
                $active = 'true';
            }
            $modeMenu[] = ['label' => $value, 'url' => [Url::current(["mode" => $key])], 'active' => $active];
        }
        return $modeMenu;
    }
}