<?php

namespace app\modules\orders\models\forms;

use Yii;
use yii\base\Model;
use yii\db\Query;
use yii\web\RangeNotSatisfiableHttpException;

class ExportForm extends Model
{
    private array $headers;
    private Query $orders;

    public function setOrders($orders)
    {
       $this->orders = $orders;
    }

    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * @throws RangeNotSatisfiableHttpException
     */
    public function exportCsv()
    {
        $data = implode(';', $this->headers) . "\r\n";
        $this->orders->orderBy(['id' => SORT_DESC]);
        foreach ($this->orders->each() as $order) {
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
        return Yii::$app->response->sendContentAsFile($data, 'orders.csv', [
            'mimeType' => 'application/csv',
            'inline'   => false
        ]);
    }
}