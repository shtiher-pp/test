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
    protected array $params;

    public function rules()
    {
        return
            [
                [['status', 'mode', 'service', 'page', 'searchType',], 'number'],
                ['status', 'in', 'range' => array_keys(Orders::getStatuses())],
                ['mode', 'in', 'range' => array_keys(Orders::getMode())],
                ['service', 'in', 'range' => range(1, Services::find()->count())],
                ['searchType', 'in', 'range' => array_keys(Orders::getSearchType())],
                [['search'], 'string', 'min' => 1],
                ['search', 'filter', 'filter' => function($value){
                    return trim( str_replace(',', '' ,$value), " \n\r\t\v\x00");
                }],
            ];
    }

    public function attributeLabels()
    {
        return [
            'mode' => 'mode',
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
            'concat(u.first_name, " ", u.last_name) full_name',
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
     * Формирует запрос с учетом условий фильтров

     * @param Query $query
     * @return Query
     */
    public function getQuery(Query $query): Query
    {
        $param = $this->getParams();
        if (isset($param['status'])) {
            $status = $param['status'];
            $query->where(['o.status' => $status]);
        }
        if   (isset($param['search']) && isset($param['searchType']) && ($param['search'] != '')) {
            $search = $param['search'];
            $searchType = $param['searchType'];
            switch ($searchType) {
                case Orders::SEARCH_ORDER_ID:
                    $query->andWhere(['o.id' => $search]);
                    break;
                case Orders::SEARCH_LINK:
                    $query->andWhere(['like', 'o.link', $search]);
                    break;
                case Orders::SEARCH_USERNAME:
                    if (strpos($search, ' ')) {
                        $userName = explode(' ', $search);
                        $query
                            ->andWhere(['or like', 'u.first_name', [$userName[0], $userName[1]]])
                            ->andWhere(['or like', 'u.last_name', [$userName[0], $userName[1]]]);
                        break;
                    }
                    $query
                        ->andWhere(['like', 'u.first_name', $search])
                        ->orWhere(['like', 'u.last_name', $search]);
                    break;
            }
        }
        if (isset($param['mode'])) {
            $mode = $param['mode'];
            $query->andWhere(['o.mode' => $mode]);
        }
        if (isset($param['service'])) {
            $service = $param['service'];
            $query->andWhere(['o.service_id' => $service]);
        }
        return $query;
    }

    /**
     * @return ArrayDataProvider
     */
    public function getOrders(): ArrayDataProvider
    {

        ini_set('memory_limit', 1170000000);

        $orders = $this
            ->getQuery($this->getOrdersQuery())
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
            $data['status'] = isset($statuses[$order['status']]) ? $statuses[$order['status']] : null;
            $data['mode'] = isset($modes[$order['mode']]) ? $modes[$order['mode']] : null;
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

    public function setParams($params)
    {
        $this->params = [];
        isset($params['status']) ?  $this->params['status'] = $params['status'] : $this->params['status'] = null;
        isset($params['mode']) ?  $this->params['mode'] = $params['mode'] : $this->params['mode'] = null;
        isset($params['service']) ?  $this->params['service'] = $params['service'] : $this->params['service'] = null;
        isset($params['page']) ?  $this->params['page'] = $params['page'] : $this->params['page'] = null;
        isset($params['searchType']) ?  $this->params['searchType'] = $params['searchType'] : $this->params['searchType'] = null;
        isset($params['search']) ?  $this->params['search'] = $params['search'] : $this->params['search'] = null;
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