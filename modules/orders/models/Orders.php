<?php

namespace app\modules\orders\models;

use Yii;
use yii\db\Query;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $user_id
 * @property string $link
 * @property int $quantity
 * @property int $service_id
 * @property int $status 0 - Pending, 1 - In progress, 2 - Completed, 3 - Canceled, 4 - Fail
 * @property int $created_at
 * @property int $mode 0 - Manual, 1 - Auto
 */


class Orders extends ActiveRecord
{
    public const PENDING_STATUS = 0;
    public const IN_PROGRESS_STATUS = 1;
    public const COMPLETED_STATUS = 2;
    public const CANCELED_STATUS = 3;
    public const FAIL_STATUS = 4;

    public const MANUAL_MODE = 0;
    public const AUTO_MODE = 1;

    public const SEARCH_ORDER_ID = 1;
    public const SEARCH_LINK = 2;
    public const SEARCH_USERNAME = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'link', 'quantity', 'service_id', 'status', 'created_at', 'mode'], 'required'],
            [['user_id', 'quantity', 'service_id', 'status', 'created_at', 'mode'], 'integer'],
            [['link'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'link' => 'Link',
            'quantity' => 'Quantity',
            'service_id' => 'Service ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'mode' => 'Mode',
        ];
    }

    /**
     * Формирует запрос с учетом условий фильтров
     */
    public static function getQuery($param): Query
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
        if   (isset($param['search'])&&isset($param['search-type'])){
            $search=$param['search'];
            $searchType=$param['search-type'];
            switch ($searchType) {
                case static::SEARCH_ORDER_ID:
                    $query->where("o.id=:search",[':search'=>$search]);
                    if (isset($status)){
                        $query->andWhere("o.status=:status", [':status' => $status]);
                    }
                    break;
                case static::SEARCH_LINK:
                    $query->where("o.link=:search",[':search'=>$search]);
                    if (isset($status)){
                        $query->andWhere("o.status=:status", [':status' => $status]);
                    }
                    break;
                case static::SEARCH_USERNAME:
                    if (strpos($search, ', ')){
                        $firstName=explode(',', $search)[0];
                        $lastName=explode(', ', $search)[1];
                    }
                    else {
                        $firstName=0;
                        $lastName=0;
                    }
                    $query
                        ->where("u.first_name=:firstName", [':firstName' => $firstName])
                        ->andWhere("u.last_name=:lastName",[':lastName'=>$lastName]);
                    if (isset($status)){
                        $query->andWhere("o.status=:status", [':status' => $status]);
                    }
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
        return $query;
    }
    public static function getStatuses(): array
    {
        return [
            static::PENDING_STATUS => "Pending",
            static::IN_PROGRESS_STATUS => "In progress",
            static::COMPLETED_STATUS => "Completed",
            static::CANCELED_STATUS => "Canceled",
            static::FAIL_STATUS => "Fail",
        ];
    }
    public static function getMode(): array
    {
        return [
            static::MANUAL_MODE => "Manual",
            static::AUTO_MODE => "Auto",
        ];
    }
    public static function getSearchType(): array
    {
        return [
            static::SEARCH_ORDER_ID => "Order ID",
            static::SEARCH_LINK => "Link",
            static::SEARCH_USERNAME => "Username",
        ];
    }
}
