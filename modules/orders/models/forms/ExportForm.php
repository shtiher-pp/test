<?php

namespace app\modules\orders\models\forms;

use app\modules\orders\models\models\Orders;
use app\modules\orders\models\searches\OrdersSearch;
use Yii;
use yii\db\ActiveRecord;
use app\modules\orders\controllers\OrdersController;

class ExportForm extends ActiveRecord
{
    /**
     * @return string
     */
    public static function exportCsv(): string
    {
//        Yii::$app->language = 'ru';
        $param = OrdersController::getParams();
        $orders = (new OrdersSearch())->getOrders($param)->getModels();
        $data = implode(';', (new Orders())->attributeLabels()) . "\r\n";
        foreach ($orders as $order) {
            $data .= $order['id'].
                ';' . $order['full_name'] .
                ';' . $order['link'] .
                ';' . $order['quantity'] .
                ';' . Yii::t('common', $order['service']) .
                ';' . Orders::getStatuses()[$order['status']] .
                ';' . Orders::getMode()[$order['mode']] .
                ';' . date('Y-m-d H:i:s',$order['created']) .
                "\r\n";
        }
        return $data;
    }
}