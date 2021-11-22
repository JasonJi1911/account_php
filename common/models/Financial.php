<?php

namespace common\models;

use yii\db\ActiveRecord;
/**
 * financial model
 *
 * @property int $Customer_id
 * @property int $net_worth
 * @property int $liquid_net_worth
 * @property int $annual_net_income
 * @property int $total_assets
 * @property string $InvestmentObjectives
 * @property string $picture
 */
class Financial extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%financial}}';
    }

    /**
     * {@inheritdoc}
     */
    public static function ClassName()
    {
        return 'Financial';
    }
}