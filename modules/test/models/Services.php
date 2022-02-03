<?php

namespace app\modules\test\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property string $name
 */
class Services extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    public static function getServices()
    {
        $services=new Query();
        $services->select(['count(O.service_id) service_count',
            'O.service_id service_id',
            'S.name service'])
            ->from(['orders O'])
            ->innerJoin('services S', 'S.id = O.service_id')
        ->groupBy('service')
        ->orderBy('service_count desc');
        return $services;
    }

}
