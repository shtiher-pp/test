<?php

namespace app\modules\orders\models\models;

use Yii;
use yii\base\DynamicModel;
use yii\base\InvalidConfigException;
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
            'id' => Yii::t('common', 'orders.id'),
            'user_id' => Yii::t('common', 'orders.user'),
            'link' => Yii::t('common', 'orders.link'),
            'quantity' => Yii::t('common', 'orders.quantity'),
            'service_id' => Yii::t('common', 'orders.service'),
            'status' => Yii::t('common', 'orders.status'),
            'mode' => Yii::t('common', 'orders.mode'),
            'created_at' => Yii::t('common', 'orders.created'),
        ];
    }

    /**
     * @return array
     */
    public static function getStatuses(): array
    {
        return [
            static::PENDING_STATUS => Yii::t('common', 'orders.pending_status'),
            static::IN_PROGRESS_STATUS => Yii::t('common', 'orders.in_progress_status'),
            static::COMPLETED_STATUS => Yii::t('common', 'orders.completed_status'),
            static::CANCELED_STATUS => Yii::t('common', 'orders.canceled_status'),
            static::FAIL_STATUS => Yii::t('common', 'orders.fail_status'),
        ];
    }

    /**
     * @return array
     */
    public static function getMode(): array
    {
        return [
            static::MANUAL_MODE => Yii::t('common', 'orders.manual_mode'),
            static::AUTO_MODE => Yii::t('common', 'orders.auto_mode'),
        ];
    }

    /**
     * @return array
     */
    public static function getSearchType(): array
    {
        return [
            static::SEARCH_ORDER_ID => Yii::t('common', 'orders.search_order_id'),
            static::SEARCH_LINK => Yii::t('common', 'orders.search_link'),
            static::SEARCH_USERNAME => Yii::t('common', 'orders.search_username'),
        ];
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
        $params = array_merge($paramsNull, Yii::$app->request->get());
        $model = DynamicModel::validateData($params, [
            Yii::$app->request->get('search-type') == static::SEARCH_ORDER_ID ? [['search'], 'number'] : ['search', 'string', 'max' => 300, 'min' => 3],
            [['status', 'mode', 'service', 'page', 'search-type'], 'number'],
            ['status', 'in', 'range' => range(0, count(Orders::getStatuses())-1)],
            ['mode', 'in', 'range' => range(static::MANUAL_MODE, static::AUTO_MODE)],
            ['service', 'in', 'range' => range(1, Services::find()->count())],
            ['search-type', 'in', 'range' => range(1, count(Orders::getSearchType()))],
            ['search', 'filter', 'filter' => function($value){
                return trim( str_replace(' ', '', $value), " \n\r\t\v\x00");
            }],
        ]);
        if ($model->hasErrors()) {
            return array_merge($paramsNull, ['error' => $model->errors]);
        } else {
            return $model->attributes;
        }
    }
}