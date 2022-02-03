<?php

namespace app\modules\test\controllers;

use app\modules\test\models\Orders;
use app\modules\test\models\Users;
use app\modules\test\models\Services;
use yii\db\Query;
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
        $services = Services::getServices()->all();
        $totalCount=Orders::find()->count();
        $query=Orders::getQuery();
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $query->count(),]);
        $orders = $query
            ->orderBy(['id'=>SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('index', [
            'orders' => $orders,
            'pagination' => $pagination,
            'services' => $services,
            'totalCount'=>$totalCount
        ]);
    }
}


//        $sql ='SELECT o.id AS id, CONCAT(u.first_name, " ", u.last_name) AS user, o.link AS link, o.quantity AS quantity, s.name AS service, o.status AS status, o.mode AS mode, o.created_at AS created FROM orders AS o
//INNER JOIN services AS s ON s.id=o.service_id
//INNER JOIN users AS u ON u.id=o.user_id
//ORDER BY o.id DESC LIMIT 50';

//        $query = new Query();
//        $query->select(['O.id id' ,
//            'U.first_name first_name',
//            'U.last_name last_name',
//            'O.link link',
//            'O.quantity quantity',
//            'S.name service',
//            'P.status status',
//            'O.mode mode',
//            'O.created_at created'])
//            ->from(['orders O'])
//            ->innerJoin('services S', 'S.id = O.service_id')
//            ->innerJoin('users U', 'U.id = O.user_id ')
//            ->innerJoin('payment_status P', 'P.id = O.status ')
//            ->orderBy(['id'=>SORT_DESC]);

//
//
//            ->where('U.id=1')
//            ->andWhere('S.id=1');



//       $query1 = Orders::findBySql($sql);
//        $query = Orders::find()->join('inner join',
//            'users',
//            'users.id = orders.user_id'
//        )
//            ->join('inner join',
//                'services',
//                'services.id = orders.service_id'
//            );
//        $services=Services::find()->orderBy('id')->all();
//        $services = new Query();
//        $services->select([
//            'count(O.service_id) service_id',
//            'S.name name',])
//            ->from(['orders O'])
//            ->innerJoin('services S', 'S.id = O.service_id')
//            ->groupBy('S.name')
//            ->orderBy('S.name')
//
//            ->all();

// $sql='SELECT s.id AS id, s.name AS name, COUNT(o.service_id) AS service_count FROM services as s
//INNER JOIN orders AS o ON  o.service_id = s.id
//GROUP BY o.service_id
//ORDER BY service_count';

//       $services = Services::findBySql($sql)->asArray()->all();
