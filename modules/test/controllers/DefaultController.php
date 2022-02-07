<?php

namespace app\modules\test\controllers;

use app\modules\test\models\Orders;
use app\modules\test\models\Services;
use Yii;
use yii\web\Controller;
use yii\data\Pagination;

/**
 * Default controller for the `test` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'orders';
        $services = Services::getServices()->all();
        $totalCount = Orders::find()->count();
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
        $status = ['Pending', 'In progress', 'Completed', 'Canceled', 'Fail'];
//        включить локаль ru
//        Yii::$app->language = 'ru';
        return $this->render('index', [
            'orders' => $orders,
            'pagination' => $pagination,
            'services' => $services,
            'totalCount' => $totalCount,
            'status' => $status
        ]);
    }
}