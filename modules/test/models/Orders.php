<?php

namespace app\modules\test\models;

use Yii;
use yii\db\Query;

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
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
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
    public function attributeLabels()
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
    public static function getQuery()
    {
        $query = new Query();
        $query->select(['O.id id' ,
            'concat(U.first_name, ", ", U.last_name) full_name',
            'O.link link',
            'O.quantity quantity',
            'S.name service',
            'O.service_id service_id',
            'O.status status',
            'O.mode mode',
            'O.created_at created',])
            ->from(['orders O'])
            ->innerJoin('services S', 'S.id = O.service_id')
            ->innerJoin('users U', 'U.id = O.user_id ');
        if (isset($_GET['status'])) {
            $status = $_GET['status'];
            if (!is_numeric($status)){
                $status=-1;
            }
            $query->where("O.status=:status", [':status' => $status]);
        }
        if   (isset($_GET['search'])){
            $search=$_GET['search'];
            $searchType=$_GET['search-type'];
            if ($search==NULL) {
                goto noSearch;
            }
            switch ($searchType) {
                case 1:
                    if (!is_numeric($search)){
                        $search=0;
                    }
                    $query->where("O.id=:search",[':search'=>$search]);
                    if (isset($status)){
                        $query->andWhere("O.status=:status", [':status' => $status]);
                    }
                    break;
                case 2:
                    $query->where("O.link=:search",[':search'=>$search]);
                    if (isset($status)){
                        $query->andWhere("O.status=:status", [':status' => $status]);
                    }
                    break;
                case 3:
                    if (strpos($search, ', ')){
                        $firstName=explode(',', $search)[0];
                        $lastName=explode(', ', $search)[1];
                    }
                    else {
                        $firstName=0;
                        $lastName=0;
                    }
                    $query
                        ->where("U.first_name=:firstName", [':firstName' => $firstName])
                        ->andWhere("U.last_name=:lastName",[':lastName'=>$lastName]);
                    if (isset($status)){
                        $query->andWhere("O.status=:status", [':status' => $status]);
                    }
                    break;
                default:
                    goto noSearch;
            }
            noSearch:
        }
        if (isset($_GET['mode'])) {
            $mode=$_GET['mode'];
            if ($mode==NULL) {
                goto noMode;
            }
            $query->andWhere("O.mode=:mode",[':mode'=>$mode]);
            noMode:
        }
        if (isset($_GET['service'])) {
            $service = $_GET['service'];
            if ($service==NULL) {
                goto noService;
            }
            $query->andWhere("O.service_id=:service",[':service'=>$service]);
            noService:
        }
        return $query;
    }
}
