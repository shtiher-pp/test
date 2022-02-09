<?php

namespace app\modules\orders\models;

use app\modules\orders\controllers\OrdersController;
use yii\data\Pagination;
use yii\db\ActiveRecord;


class ExportForm extends ActiveRecord
{


    public static function exportCsv()
    {

        $param = OrdersController::getParams();
        $query = SearhOrders::getQuery($param);
        $pagination = new Pagination([
            'defaultPageSize' =>  OrdersController::DEFAULT_PAGE_SIZE,
            'totalCount' => $query->count(),
            'pageSizeLimit' => false,
        ]);
        $orders = $query
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
        return $data;
    }
}