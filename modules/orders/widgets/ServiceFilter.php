<?php

namespace app\modules\orders\widgets;

use app\modules\orders\models\searches\OrdersSearch;
use app\modules\orders\widgets\CustomFilter;
use Yii;
use yii\db\Query;
use yii\helpers\Html;
use yii\helpers\Url;

class ServiceFilter extends CustomFilter
{
    public Query $services;

    /**
     * @return array
     */
    public function getMenu(): array
    {
        $services = $this->services->all();
        $count = $this->services->sum('service_count');
        $serviceMenu = [['label' => Yii::t('common', 'All') . ' (' . $count . ')',
            'url' => [Url::current(["service" => OrdersSearch::ALL_SERVICES_MENU])],
            'active' => isset($this->param['service']) ? '' : 'true'
        ]];
        foreach ($services as $service) {
            $serviceMenu[] = [
                'label' => Html::tag('span', Html::encode($service['service_count']), ['class' => 'label-id']) . $service['service'],
                'url' => [Url::current(["service" => $service['service_id']])],
                'active' => !isset($this->param['service']) ? '' : 'true'
            ];
        }
        return $serviceMenu;
    }
}