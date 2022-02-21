<?php

namespace app\modules\orders\models\searches;

use app\modules\orders\models\models\Orders;
use app\modules\orders\models\models\Services;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\db\Query;

/**
 *
 * @property $mode
 * @property $status
 * @property $service
 * @property $page
 * @property $service_id
 * @property $searchType
 */

class OrdersSearch extends Model
{
    public const DEFAULT_PAGE_SIZE = 100;
    public const ALL_SERVICES_MENU = null;

    public $mode;
    public $status;
    public $service;
    public $page;
    public $search;
    public $searchType;

    /**
     * @var array|null[]
     */
    private array $params;

    public function rules()
    {
        return
            [
                [['status', 'mode', 'service', 'page', 'searchType'], 'number'],
                ['status', 'in', 'range' => array_keys(Orders::getStatuses())],
                ['mode', 'in', 'range' => array_keys(Orders::getMode())],
                ['service', 'in', 'range' => range(1, Services::find()->count())],
                ['searchType', 'in', 'range' => array_keys(Orders::getSearchType())],
                ['search', 'filter', 'filter' => function($value){
                    return trim( str_replace(' ', '', $value), " \n\r\t\v\x00");
                }],
            ];
    }

    public function attributeLabels()
    {
        return ['mode' => 'mode',
            'status' => 'status',
            'service' => 'service',
            'page' => 'page',
            'search' => 'search',
            'searchType' => 'searchType',
        ];
    }

    /**
     * @return Query
     */
    public function getOrdersQuery(): Query
    {
        $query = new Query();
        $query->select(['o.id id' ,
            'concat(u.first_name, ", ", u.last_name) full_name',
            'o.link link',
            'o.quantity quantity',
            's.name service',
            'o.service_id service_id',
            'o.status status',
            'o.mode mode',
            'o.created_at created',])
            ->from(['orders o'])
            ->innerJoin('services s', 's.id = o.service_id')
            ->innerJoin('users u', 'u.id = o.user_id ');
        return $query;
    }

    /**
     * @return Query
     */
    public function getServicesQuery(): Query
    {
        $services = new Query();
        $services->select(['s.id service_id',
            's.name service',
            'count(o.service_id) service_count'])
            ->from(['services s'])
            ->innerJoin('orders o', 'o.service_id = s.id')
            ->innerJoin('users u', 'u.id = o.user_id ');
        return $services;
    }

    /**
     * Формирует запрос с учетом условий фильтров
     * @param array $param
     * @param Query $query
     * @return Query
     */
    public function getQuery(array $param, Query $query): Query
    {
        if (isset($param['status'])) {
            $status = $param['status'];
            $query->where(['o.status' => $status]);
        }
        if   (isset($param['search']) && isset($param['searchType'])) {
            $search=$param['search'];
            $searchType=$param['searchType'];
            switch ($searchType) {
                case Orders::SEARCH_ORDER_ID:
                    $query->andWhere(['o.id' => $search]);
                    break;
                case Orders::SEARCH_LINK:
                    $query->andWhere(['like', 'o.link', $search]);
                    break;
                case Orders::SEARCH_USERNAME:
                    if (strpos($search, ',')) {
                        $userName = explode(',', $search);
                        $query
                            ->andWhere(['like', 'u.first_name', $userName[0]])
                            ->andWhere(['like', 'u.last_name', $userName[1]]);
                        break;
                    }
                    $query
                        ->andWhere(['like', 'u.first_name', $search])
                        ->orWhere(['like', 'u.last_name', $search]);
                    break;
            }
        }
        if (isset($param['mode'])) {
            $mode=$param['mode'];
            $query->andWhere(['o.mode' => $mode]);
        }
        if (isset($param['service'])) {
            $service = $param['service'];
            $query->andWhere(['o.service_id' => $service]);
        }
        return $query;
    }

    /**
     * @param array $param
     * @return ArrayDataProvider
     */
    public function getOrders(array $param): ArrayDataProvider
    {

        ini_set('memory_limit', 1170000000);

        $orders = $this
            ->getQuery($param, $this->getOrdersQuery())
            ->orderBy(['id' => SORT_DESC]);
        $statuses = Orders::getStatuses();
        $modes = Orders::getMode();
        $data = [];
        $dataArray = [];
        foreach ($orders->each() as $order) {
            $data['id'] = $order['id'];
            $data['full_name'] = $order['full_name'];
            $data['link'] = $order['link'];
            $data['quantity'] = $order['quantity'];
            $data['service'] = $order['service'];
            $data['service_id'] = $order['service_id'];
            $data['status'] = $statuses[$order['status']];
            $data['mode'] = $modes[$order['mode']];
            $data['created'] = date('Y-m-d H:i:s',$order['created']);
            $dataArray[] = $data;
        }
        return new ArrayDataProvider([
            'allModels' => $dataArray,
            'pagination' => [
                'pageSize' => OrdersSearch::DEFAULT_PAGE_SIZE,
            ],
        ]);
    }

    /**
     * Возвращает список сервисов с количеством записей в заказах
     * @param $param
     * @return Query
     */
    public function getServices($param): Query
    {
        return (new OrdersSearch())
            ->getQuery($param, $this->getServicesQuery())
            ->groupBy('o.service_id')
            ->orderBy('service_count desc');
    }

    public function setParams($params)
    {
        $paramDefault = [
            'status' => null,
            'mode' => null,
            'service' => null,
            'page' => null,
            'searchType' => null,
            'search' => null
        ];
        $this->params = array_merge($paramDefault, $params);
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        $model = new OrdersSearch($this->params);
        if ($model->validate()) {
            return $model->attributes;
        } else {
            return array_merge($this->params, ['error' => $model->errors]);
        }
    }
}