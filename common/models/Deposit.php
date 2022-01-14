<?php

namespace common\models;

use common\behaviors\UploadBehavior;
use phpDocumentor\Reflection\Types\This;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * deposit model
 *
 * @property integer $id
 * @property integer $Customer_id
 * @property integer $uid
 * @property string $bankName
 * @property string $banBSB
 * @property string $bankAccount
 * @property string $currency
 * @property string $amount
 * @property string $isSave
 */

class Deposit extends ActiveRecord
{
    const CURRENCY_AUD = 'AUD'; // 澳币AUD
    const CURRENCY_USD = 'USD'; // 美元USD
    const CURRENCY_HKD = 'HDK'; // 港币HKD

    public static $currency = [
        self::CURRENCY_AUD => '澳币AUD',
        self::CURRENCY_USD => '美元USD',
        self::CURRENCY_HKD => '港币HKD',
    ];

    public function rules()
    {
        return [
            [['bankName'], 'required', 'message' => '银行名称不能为空'],
            [['bankAccount'], 'required', 'message' => '银行账号不能为空.'],
            [['currency'], 'required', 'message' => '转账货币不能为空.'],
            [['amount'], 'required', 'message' => '转账金额不能为空.'],
            [['isSave'], 'required', 'message' => ''],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%deposit}}';
    }

    /**
     * {@inheritdoc}
     */
    public static function ClassName()
    {
        return 'Deposit';
    }
}