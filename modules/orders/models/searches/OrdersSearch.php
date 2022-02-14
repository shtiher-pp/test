<?php

namespace app\modules\orders\models\searches;

use app\modules\orders\models\models\Orders;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Url;

class OrdersSearch extends ActiveRecord
{
    public const DEFAULT_PAGE_SIZE = 100;
    public const ALL_SERVICES_MENU = null;

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
     * @param array $param
     * @return ActiveDataProvider
     */
    public static function getOrders(array $param): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => OrdersSearch::getQuery($param),
            'pagination' => [
                'pageSize' => OrdersSearch::DEFAULT_PAGE_SIZE,
            ],
        ]);
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

    /**
     * Формирует массив для выпадающено списка services
     * @return array
     */
    public static function getServicesMenu(): array
    {
        $services = static::getServices();
        $serviceMenu = [['label' => Yii::t('common', 'All') . ' (' . Orders::find()->count() . ')', 'url' => [Url::current(["service" => static::ALL_SERVICES_MENU])]]];
        foreach ($services as $service) {
            $serviceMenu[] = [
                'label' => Html::tag('span', Html::encode($service['service_count']), ['class' => 'label-id']
                    ) . Yii::t('common', $service['service']),
                'url' => [Url::current(["service" => $service['service_id']])],
            ];
        }
        return $serviceMenu;
    }
}