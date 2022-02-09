<?php

namespace app\modules\orders\controllers;

use yii\data\Pagination;
use yii\web\Controller;
use app\modules\orders\models\Orders;

class ExportController extends Controller {
    /**
     * Экспорт товаров в csv файл
     */

    public function actionIndex()
    {
        $this->layout = '_export';
        $param = OrdersController::getParams();
        $query = Orders::getQuery($param);
        $pagination = new Pagination([
            'defaultPageSize' => OrdersController::DEFAULT_PAGE_SIZE,
            'totalCount' => $query->count(),
            'pageSizeLimit' => false,
        ]);
        return $this->render('exportForm', [
            'query' => $query,
            'pagination' => $pagination
        ]);
    }


}