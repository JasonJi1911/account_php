<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * financial_range model
 *
 * @property string $currency
 * @property string $criteria
 * @property int $lower_bound
 * @property int $upper_bound
 * @property int $range_id
 */
class FinancialRange extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%financial_range}}';
    }
}