<?php

namespace app\modules\orders\widgets;

use app\modules\orders\models\searches\OrdersSearch;
use app\modules\orders\widgets\CustomFilter;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class ServiceFilter extends CustomFilter
{
    /**
     * @return array
     */
    public function getMenu(): array
    {
        $query = (new OrdersSearch())->getServices($this->param);
        $services = $query->all();
        $count = $query->sum('service_count');
        $serviceMenu = [['label' => Yii::t('common', 'All') . ' (' . $count . ')',
            'url' => [Url::current(["service" => OrdersSearch::ALL_SERVICES_MENU])]
        ]];
        foreach ($services as $service) {
            $serviceMenu[] = [
                'label' => Html::tag('span', Html::encode($service['service_count']), ['class' => 'label-id']) . $service['service'],
                'url' => [Url::current(["service" => $service['service_id']])],
            ];
        }
        return $serviceMenu;
    }
}