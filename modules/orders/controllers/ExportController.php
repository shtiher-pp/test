<?php

namespace app\modules\orders\controllers;

use app\modules\orders\models\forms\ExportForm;
use app\modules\orders\models\models\Orders;
use app\modules\orders\models\searches\OrdersSearch;
use Yii;
use yii\web\Controller;
use yii\web\RangeNotSatisfiableHttpException;

class ExportController extends Controller
{
    /**
     * Экспорт товаров в csv файл
     * @throws RangeNotSatisfiableHttpException
     */
    public function actionIndex()
    {
        $orderSearch = new OrdersSearch();
        $orderSearch->setParams(Yii::$app->request->get());
        $param = $orderSearch->getParams();
        $headers = (new Orders())->attributeLabels();
        $orders  = $orderSearch->getQuery($param, $orderSearch->getOrdersQuery());
        $export = new ExportForm();
        $export->setHeaders($headers);
        $export->setOrders($orders);
        return $export->exportCsv();
    }
}