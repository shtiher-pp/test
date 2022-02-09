<?php

use yii\data\Pagination;
use \yii\db\Query;

/* @var $query Query */
/* @var $pagination Pagination */

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
Yii::$app->response->sendContentAsFile($data, 'orders.csv', [
    'mimeType' => 'application/csv',
    'inline'   => false
]);
?>
<?=$data?>