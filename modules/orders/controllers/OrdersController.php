<?php

namespace app\modules\orders\controllers;

use app\modules\orders\models\models\Orders;
use app\modules\orders\models\models\Services;
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
//        включить локаль ru
//        Yii::$app->language = 'ru';
        $this->layout = '_layout';
        $param = static::getParams();
        $servicesMenu = (new OrdersSearch())->getServicesMenu();
        $statuses = Orders::getStatuses();
        $modeMenu = Orders::getModeMenu();
        $search = Orders::getSearchType();
        $orders = (new OrdersSearch())->getOrders($param);
        $headers = (new Orders())->attributeLabels();
        return $this->render('index', [
            'orders' => $orders,
            'statuses' => $statuses,
            'search'=> $search,
            'param' => $param,
            'modeMenu' => $modeMenu,
            'servicesMenu' => $servicesMenu,
            'headers' => $headers,
        ]);
    }

    /**
     * @return array
     */
    public static function getParams(): array
    {
        $param = [];
        if (isset($_GET['status']) && array_key_exists($_GET['status'], Orders::getStatuses())) {
            $param += ['status' => $_GET['status']];
        }
        if (isset($_GET['mode']) && array_key_exists($_GET['mode'], Orders::getMode())) {
            $param += ['mode' => $_GET['mode']];
        }
        if (isset($_GET['service']) && Services::findOne($_GET['service'])) {
            $param += ['service' => $_GET['service']];
        }
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $param += ['page' => $_GET['page']];
        }
        if (isset($_GET['search-type']) && isset($_GET['search']) && array_key_exists($_GET['search-type'], Orders::getSearchType())) {
            $param += ['search-type' => $_GET['search-type']];
            $param += ['search' => $_GET['search']];
        }
        return $param;
    }
}