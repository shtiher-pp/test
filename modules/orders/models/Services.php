<?php

namespace app\modules\orders\models;

use Yii;
use yii\db\Query;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property string $name
 */
class Services extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
    /**
     * Возвращает список сервисов с количеством записей в заказах
     * @return Query
     */
    public static function getServices(): Query
    {
        $services=new Query();
        $services->select(['s.id service_id',
            's.name service',
            'COUNT(o.service_id) service_count'])
            ->from(['services s'])
            ->innerJoin('orders o', 'o.service_id = s.id')
            ->groupBy('o.service_id')
            ->orderBy('service_count desc');
        return $services;
    }
}
