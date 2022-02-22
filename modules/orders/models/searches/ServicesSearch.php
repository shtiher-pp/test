<?php

namespace app\modules\orders\models\searches;

use yii\base\Model;
use yii\db\Query;

class ServicesSearch extends Model
{
    protected OrdersSearch $orderSearch;

    public function __construct(OrdersSearch $orderSearch)
    {
        parent::__construct();
        $this->orderSearch = $orderSearch;
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
     * Возвращает список сервисов с количеством записей в заказах
     * @return Query
     */
    public function getServices(): Query
    {
        return $this->orderSearch->getQuery($this->getServicesQuery())
            ->groupBy('o.service_id')
            ->orderBy('service_count desc');
    }
}