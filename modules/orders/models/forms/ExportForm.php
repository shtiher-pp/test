<?php

namespace app\modules\orders\models\forms;

use app\modules\orders\models\models\Orders;
use app\modules\orders\models\searches\OrdersSearch;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

class ExportForm extends ActiveRecord
{
    /**
     * @throws InvalidConfigException
     */
    public static function exportCsv()
    {
        $text = implode(';', (new Orders())->attributeLabels()) . "\r\n";
        $filename = '/app/output/orders.csv';
        $param = OrdersSearch::getParams();
        $orders = (new OrdersSearch())->getOrders($param)->getModels();
        $fh = fopen($filename, 'w');
        fwrite($fh, $text);
        foreach ($orders as $order) {
            fwrite($fh, $order['id'].
                ';' . $order['full_name'] .
                ';' . $order['link'] .
                ';' . $order['quantity'] .
                ';' . $order['service'] .
                ';' . $order['status'] .
                ';' . $order['mode'] .
                ';' . $order['created'] .
                "\r\n");
        }
        fclose($fh);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filename));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filename));
        readfile($filename);
        exit;
    }
}