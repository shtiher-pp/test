<?php

namespace app\modules\orders\widgets;

use Exception;
use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\Menu;

class CustomFilter extends Widget
{
    public string $items;
    public string $headers;
    public array $param;

    public array $menu;

    public const FILTER_MENU = 'menu';

    public function init() {
        parent::init();
        if ($this->items == static::FILTER_MENU) {
            $this->menu = $this->getMenu();
        }
    }

    /**
     * @return string
     * @throws Exception
     */
    public function run(): string
    {
        $menu = Menu::widget([
            'items' => $this->menu,
            'encodeLabels' => false,
            'firstItemCssClass' => 'active',
            'options' => [
                'aria-labelledby' => 'dropdownMenu1',
                'class' => 'dropdown-menu',
            ],
        ]);
        $buttonContent = $this->headers . Html::tag('span', '', ['class' => 'caret']);
        $button = Html::button($buttonContent, [
            'class' => 'btn btn-th btn-default dropdown-toggle',
            'type' => "button",
            'id' =>"dropdownMenu1",
            'data-toggle' =>"dropdown",
            'aria-haspopup' =>"true",
            'aria-expanded' =>"true"
        ]);
        $content = $menu . $button;
        return Html::tag('div', $content, ['class' => 'dropdown']);
    }

    /**
     * @return array
     */
    public function getMenu(): array
    {
        return $this->menu;
    }
}