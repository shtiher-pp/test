<?php

namespace app\modules\test\controllers;

use app\modules\test\models\Orders;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;

class ExportController extends Controller {
    /**
     * Экспорт товаров в csv файл
     */
    public function actionIndex()
    {
        $query = Orders::getQuery();
        $pagination = new Pagination([
            'defaultPageSize' => 100,
            'totalCount' => $query->count(),
        ]);
        $orders = $query
            ->orderBy(['id' => SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $data = "id;user;link;quantity;service;status;mode;created\r\n";
        foreach ($orders as $order) {
            $data .= $order['id'].
                ';' . $order['full_name'] .
                ';' . $order['link'] .
                ';' . $order['quantity'] .
                ';' . $order['service'] .
                ';' . $order['status'] .
                ';' . $order['mode'] .
                ';' . date('Y-m-d H:i:s',$order['created']) .
                "\r\n";
        }
        return \Yii::$app->response->sendContentAsFile($data, 'orders.csv', [
            'mimeType' => 'application/csv',
            'inline'   => false
        ]);
    }
}