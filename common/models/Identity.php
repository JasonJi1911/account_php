<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * Candidate model
 *
 * @property integer $Customer_id
 * @property integer $type
 * @property string $number
 * @property string $issue_country
 * @property string $issue_state
 * @property string $expiration
 * @property string $RTA
 * @property integer $created_at
 * @property integer $updated_at
 */

class Identity extends ActiveRecord
{
    const TYPE_NATIONALCARD = 'NationalCard'; // 身份证
    const TYPE_PASSPORT = 'Passport'; // 护照
    const TYPE_DRIVERSLICENSE = 'DriversLicense'; // 驾照

    public static $types = [
        self::TYPE_NATIONALCARD => '身份证',
        self::TYPE_PASSPORT => '护照',
        self::TYPE_DRIVERSLICENSE => '驾照',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%identity}}';
    }

    /**
     * {@inheritdoc}
     */
    public static function ClassName()
    {
        return 'Identity';
    }
}