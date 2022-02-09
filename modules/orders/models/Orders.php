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
     * @return array
     */
    public static function getStatuses(): array
    {
        return [
            static::PENDING_STATUS => Yii::t('common', 'Pending'),
            static::IN_PROGRESS_STATUS => Yii::t('common', 'In progress'),
            static::COMPLETED_STATUS => Yii::t('common', 'Completed'),
            static::CANCELED_STATUS => Yii::t('common', 'Canceled'),
            static::FAIL_STATUS => Yii::t('common', 'Fail'),
        ];
    }

    /**
     * @return array
     */
    public static function getMode(): array
    {
        return [
            static::MANUAL_MODE => Yii::t('common', 'Manual'),
            static::AUTO_MODE => Yii::t('common', 'Auto'),
        ];
    }

    /**
     * @return array
     */
    public static function getSearchType(): array
    {
        return [
            static::SEARCH_ORDER_ID => Yii::t('common', 'Order ID'),
            static::SEARCH_LINK => Yii::t('common', 'Link'),
            static::SEARCH_USERNAME => Yii::t('common', 'Username'),
        ];
    }
}
