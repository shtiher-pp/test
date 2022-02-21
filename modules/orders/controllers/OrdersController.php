<?php

namespace app\modules\orders\controllers;

use app\modules\orders\models\models\Orders;
use app\modules\orders\models\searches\OrdersSearch;
use Yii;
use yii\web\Controller;

/**
 * Default controller for the `orders` module
 */
class OrdersController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex(): string
    {
        $orderSearch = new OrdersSearch();
        $orderSearch->setParams(Yii::$app->request->get());
        $param = $orderSearch->getParams();
        $statuses = Orders::getStatuses();
        $services = $orderSearch->getServices($param);
        $search = Orders::getSearchType();
        $orders = $orderSearch->getOrders($param);
        $headers = (new Orders())->attributeLabels();
        return $this->render('index', [
            'orders' => $orders,
            'statuses' => $statuses,
            'search'=> $search,
            'param' => $param,
            'headers' => $headers,
            'services' => $services,
        ]);
    }
}