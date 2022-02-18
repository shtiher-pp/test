<?php

namespace app\modules\orders\models\forms;

use app\modules\orders\models\models\Orders;
use app\modules\orders\models\searches\OrdersSearch;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

class ExportForm extends ActiveRecord
{
    /**
     * @return string
     * @throws InvalidConfigException
     */
    public static function exportCsv(): string
    {
        $param = Orders::getParams();
        $orders  = (new OrdersSearch())->getQuery($param, (new OrdersSearch())->getOrdersQuery())
            ->orderBy(['id' => SORT_DESC])->each();
        $data = implode(';', (new Orders())->attributeLabels()) . "\r\n";
        foreach ($orders as $order) {
            $data .= $order['id'].
                ';' . $order['full_name'] .
                ';' . $order['link'] .
                ';' . $order['quantity'] .
                ';' . $order['service'] .
                ';' . $order['status'] .
                ';' . $order['mode'] .
                ';' . $order['created'] .
                "\r\n";
        }
        return $data;
    }
}