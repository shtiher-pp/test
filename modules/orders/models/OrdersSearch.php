<?php

namespace app\modules\orders\models;

use yii\db\Query;
use yii\db\ActiveRecord;

class OrdersSearch extends ActiveRecord
{
    /**
     * Формирует запрос с учетом условий фильтров
     * @param array $param
     * @return Query
     */
    public static function getQuery(array $param): Query
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
        if (isset($param['status'])) {
            $status = $param['status'];
            $query->where("o.status=:status", [':status' => $status]);
        }
        if   (isset($param['search'])&&isset($param['search-type'])) {
            $search=$param['search'];
            $searchType=$param['search-type'];
            switch ($searchType) {
                case Orders::SEARCH_ORDER_ID:
                    $query->andWhere("o.id=:search",[':search'=>$search]);
                    break;
                case Orders::SEARCH_LINK:
                    $query->andWhere("o.link=:search",[':search'=>$search]);
                    break;
                case Orders::SEARCH_USERNAME:
                    if (strpos($search, ', ')) {
                        $firstName=explode(',', $search)[0];
                        $lastName=explode(', ', $search)[1];
                    }
                    else {
                        $firstName=0;
                        $lastName=0;
                    }
                    $query
                        ->andWhere("u.first_name=:firstName", [':firstName' => $firstName])
                        ->andWhere("u.last_name=:lastName",[':lastName'=>$lastName]);
                    break;
            }
        }
        if (isset($param['mode'])) {
            $mode=$param['mode'];
            $query->andWhere("o.mode=:mode",[':mode'=>$mode]);
        }
        if (isset($param['service'])) {
            $service = $param['service'];
            $query->andWhere("o.service_id=:service",[':service'=>$service]);
        }
        return $query->orderBy(['id' => SORT_DESC]);
    }

    /**
     * Возвращает список сервисов с количеством записей в заказах
     * @return array
     */
    public static function getServices(): array
    {
        $services=new Query();
        $services->select(['s.id service_id',
            's.name service',
            'COUNT(o.service_id) service_count'])
            ->from(['services s'])
            ->innerJoin('orders o', 'o.service_id = s.id')
            ->groupBy('o.service_id')
            ->orderBy('service_count desc');
        return $services->all();
    }
}