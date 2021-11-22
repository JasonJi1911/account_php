<?php

namespace common\models\info;

use Yii;
use yii\db\ActiveRecord;

/**
 * Account model
 *
 * @property int $Customer_id
 * @property string $base_currency
 * @property string $multicurrency
 * @property string $margin
 * @property string $AccountType
 * @property string $InvestmentObjectives
 */
class Account extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%account}}';
    }

    /**
     * {@inheritdoc}
     */
    public static function ClassName()
    {
        return 'Account';
    }
}