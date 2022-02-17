<?php

namespace app\modules\orders\models\searches;

use app\modules\orders\models\models\Orders;
use app\modules\orders\models\models\Services;
use yii\base\DynamicModel;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\db\ActiveRecord;

class OrdersSearch extends ActiveRecord
{
    public const DEFAULT_PAGE_SIZE = 100;
    public const ALL_SERVICES_MENU = null;

    /**
     * @return Query
     */
    public function getOrdersQuery(): Query
    {
        $mode = Orders::getMode();
        $status = Orders::getStatuses();
        $query = new Query();
        $query->select(['o.id id' ,
            'concat(u.first_name, ", ", u.last_name) full_name',
            'o.link link',
            'o.quantity quantity',
            's.name service',
            'o.service_id service_id',
            'o.status status',
            "case `o`.`status` when 0 then '$status[0]' when 1 then '$status[1]' when 2 then '$status[2]' when 3 then '$status[3]' when 4 then '$status[4]' end as status",
            "case `o`.`mode` when 0 then '$mode[0]' when 1 then '$mode[1]' end as mode",
            'date_format(from_unixtime(`o`.`created_at`), "%Y-%m-%d %H:%i:%s") as `created`',])
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
            $query->where("o.status=:status", [':status' => $status]);
        }
        if   (isset($param['search']) && isset($param['search-type'])) {
            $search=$param['search'];
            $searchType=$param['search-type'];
            switch ($searchType) {
                case Orders::SEARCH_ORDER_ID:
                    $query->andWhere("o.id=:search",[':search' => $search]);
                    break;
                case Orders::SEARCH_LINK:
                    $query->andWhere(['like', 'o.link', $search]);
                    break;
                case Orders::SEARCH_USERNAME:
                    if (strpos($search, ', ')) {
                        $userName = explode(', ', $search);
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
            $query->andWhere("o.mode=:mode",[':mode' => $mode]);
        }
        if (isset($param['service'])) {
            $service = $param['service'];
            $query->andWhere("o.service_id=:service",[':service' => $service]);
        }
        return $query;
    }

    /**
     * @param array $param
     * @return ActiveDataProvider
     */
    public function getOrders(array $param): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => (new OrdersSearch())
                ->getQuery($param, (new OrdersSearch())->getOrdersQuery())
                ->orderBy(['id' => SORT_DESC]),
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
            ->getQuery($param, (new OrdersSearch())->getServicesQuery())
            ->groupBy('o.service_id')
            ->orderBy('service_count desc');
    }

    /**
     * @return array
     * @throws InvalidConfigException
     */
    public static function getParams(): array
    {
        $paramsNull = [
            'status' => null,
            'mode' => null,
            'service' => null,
            'page' => null,
            'search-type' => null,
            'search' => null
        ];
        $params = array_merge($paramsNull, $_GET);
        $model = DynamicModel::validateData($params, [
            ['search', 'string', 'max' => 300, 'min' => 3],
            [['status', 'mode', 'service', 'page', 'search-type'], 'number'],
            ['status', 'in', 'range' => range(0, count(Orders::getStatuses())-1)],
            ['mode', 'in', 'range' => range(0, 1)],
            ['service', 'in', 'range' => range(1, Services::find()->count())],
            ['search-type', 'in', 'range' => range(1, count(Orders::getSearchType()))],
        ]);
        if ($model->hasErrors()) {
            return array_merge($paramsNull, ['error' => $model->errors]);
        } else {
            return $params;
        }
    }
}