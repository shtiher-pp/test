<?php

namespace app\modules\orders\controllers;

use app\modules\orders\models\models\Orders;
use app\modules\orders\models\searches\OrdersSearch;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\Controller;

/**
 * Default controller for the `orders` module
 */
class OrdersController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     * @throws InvalidConfigException
     */
    public function actionIndex(): string
    {
        Yii::$app->language = 'ru';
        $param = OrdersSearch::getParams();
        $statuses = Orders::getStatuses();
        $search = Orders::getSearchType();
        $orders = (new OrdersSearch())->getOrders($param);
        $headers = (new Orders())->attributeLabels();
        return $this->render('index', [
            'orders' => $orders,
            'statuses' => $statuses,
            'search'=> $search,
            'param' => $param,
            'headers' => $headers,
        ]);
    }

}