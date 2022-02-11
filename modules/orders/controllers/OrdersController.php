<?php

namespace app\modules\orders\controllers;

use app\modules\orders\models\OrdersSearch;
use yii\data\Pagination;
use yii\web\Controller;
use app\modules\orders\models\Services;
use app\modules\orders\models\Orders;

/**
 * Default controller for the `orders` module
 */
class OrdersController extends Controller
{
    public const DEFAULT_PAGE_SIZE = 100;

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex(): string
    {
//        включить локаль ru
//        Yii::$app->language = 'ru';
        $this->layout = '_layout';
        $param = static::getParams();
        $services = OrdersSearch::getServices();
        $totalCount = Orders::find()->count();
        $query = OrdersSearch::getQuery($param);
        $pagination = new Pagination([
            'defaultPageSize' => static::DEFAULT_PAGE_SIZE,
            'totalCount' => $query->count(),
            'pageSizeLimit' => false,
        ]);
        $orders = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $status = Orders::getStatuses();
        $mode = Orders::getMode();
        $search = Orders::getSearchType();
        $pages = static::getPages($param, $pagination);
        return $this->render('index', [
            'orders' => $orders,
            'pagination' => $pagination,
            'services' => $services,
            'totalCount' => $totalCount,
            'status' => $status,
            'mode' => $mode,
            'search'=> $search,
            'param' => $param,
            'pages' => $pages,
        ]);
    }

    /**
     * @return array
     */
    public static function getParams(): array
    {
        $param = [];
        if (isset($_GET['status'])&&array_key_exists($_GET['status'], Orders::getStatuses())) {
            $param += ['status' => $_GET['status']];
        }
        if (isset($_GET['mode'])&&array_key_exists($_GET['mode'], Orders::getMode())) {
            $param += ['mode' => $_GET['mode']];
        }
        if (isset($_GET['service'])&&Services::findOne($_GET['service'])) {
            $param += ['service' => $_GET['service']];
        }
        if (isset($_GET['page'])&&is_numeric($_GET['page'])) {
            $param += ['page' => $_GET['page']];
        }
        if (isset($_GET['search-type'])&&isset($_GET['search'])&&array_key_exists($_GET['search-type'], Orders::getSearchType())) {
            $param += ['search-type' => $_GET['search-type']];
            $param += ['search' => $_GET['search']];
        }
        return $param;
    }

    /**
     * @param array $param
     * @param Pagination $pagination
     * @return string
     */
    public static function getPages(array $param, Pagination $pagination): string
    {
        if ($pagination->totalCount<1) {
            return '';
        }
        if (!isset($param['page'])&&(!is_null($pagination->totalCount))&&($pagination->totalCount<$pagination->defaultPageSize)) {
            return '1' . ' to '. $pagination->totalCount.' of '. $pagination->totalCount;
        }
        if (!isset($param['page'])&&(!is_null($pagination->totalCount))&&!($pagination->totalCount<$pagination->defaultPageSize)) {
            return '1' . ' to '. $pagination->defaultPageSize.' of '. $pagination->totalCount;
        }
        if (isset($param['page'])&&$param['page']!=ceil($pagination->totalCount/$pagination->defaultPageSize)) {
            return (($param['page']-1)*$pagination->defaultPageSize)+1 .' to '. $param['page']*$pagination->defaultPageSize.' of '. $pagination->totalCount;
        }
        if (isset($param['page'])&&$param['page']>1&&$param['page']==ceil($pagination->totalCount/$pagination->defaultPageSize)) {
            return (($param['page']-1)*$pagination->defaultPageSize)+1 .' to '. $pagination->totalCount .' of '. $pagination->totalCount;
        }
        return '';
    }
}