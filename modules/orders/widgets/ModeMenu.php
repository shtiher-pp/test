<?php

namespace app\modules\orders\widgets;

use app\modules\orders\models\models\Orders;
use app\modules\orders\models\searches\OrdersSearch;
use Exception;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;

class ModeMenu extends Widget
{
    public string $items;
    public array $menu;

    public const MODE_MENU = 'modeMenu';
    public const SERVICE_MENU = 'serviceMenu';

    /**
     * @throws InvalidConfigException
     */
    public function init() {
        parent::init();
        if ($this->items == static::MODE_MENU) {
            $this->menu = static::getModeMenu();
        }
        if ($this->items == static::SERVICE_MENU) {
            $this->menu = static::getServicesMenu(OrdersSearch::getParams());
        }
    }

    /**
     * @return string
     * @throws Exception
     */
    public function run(): string
    {
        return Menu::widget([
            'items' => $this->menu,
            'encodeLabels' => false,
            'firstItemCssClass' => 'active',
            'options' => [
                'aria-labelledby' => 'dropdownMenu1',
                'class' => 'dropdown-menu',
            ],
        ]);
    }

    /**
     * @return array
     */
    public static function getModeMenu(): array
    {
        $modeMenu = [['label' => Yii::t('common', 'All'), 'url' => [Url::current(["mode" => null])]]];
        foreach (Orders::getMode() as $key => $value) {
            $modeMenu[] = ['label' => $value, 'url' => [Url::current(["mode" => $key])]];
        }
        return $modeMenu;
    }

    /**
     * @param $param
     * @return array
     */
    public static function getServicesMenu($param): array
    {
        $query = (new OrdersSearch())->getServices($param);
        $services = $query->all();
        $count = $query->sum('service_count');
        $serviceMenu = [['label' => Yii::t('common', 'All') . ' (' . $count . ')',
            'url' => [Url::current(["service" => OrdersSearch::ALL_SERVICES_MENU])]
        ]];
        foreach ($services as $service) {
            $serviceMenu[] = [
                'label' => Html::tag('span', Html::encode($service['service_count']), ['class' => 'label-id'])  . $service['service'],
                'url' => [Url::current(["service" => $service['service_id']])],
            ];
        }
        return $serviceMenu;
    }
}