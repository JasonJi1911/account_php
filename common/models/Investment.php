<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Investment model
 *
 * @property int $Customer_id
 * @property string $asset_class
 * @property string $years_trading
 * @property string $trades_per_year
 * @property string $knowledge_level
 * @property string $TradingPermission
 */
class Investment extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%investment}}';
    }
}