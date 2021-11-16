<?php

namespace common\models;

/**
 * Candidate model
 *
 * @property integer $Customer_id
 * @property integer $street
 * @property string $post
 * @property string $country
 * @property string $city
 * @property string $state
 */
class Resident extends \yii\db\ActiveRecord
{
    const STATE_NSW = 'AU-NSW'; // 新南威尔士州
    const STATE_VIC = 'AU-VIC'; // 维多利亚州
    const STATE_QLD = 'AU-QLD'; // 昆士兰州
    const STATE_WA = 'AU-WA'; // 西澳大利亚州
    const STATE_SA = 'AU-SA'; // 南澳大利亚州
    const STATE_TAS = 'AU-TAS'; // 塔斯玛尼亚州
    const STATE_ACT = 'AU-ACT'; // 首都领地
    const STATE_NT = 'AU-NT'; // 北领地

    public static $states = [
        self::STATE_NSW => '新南威尔士州',
        self::STATE_VIC => '维多利亚州',
        self::STATE_QLD => '昆士兰州',
        self::STATE_WA => '西澳大利亚州',
        self::STATE_SA => '南澳大利亚州',
        self::STATE_TAS => '塔斯玛尼亚州',
        self::STATE_ACT => '首都领地',
        self::STATE_NT => '北领地',
    ];

    public function rules()
    {
        return [
            [['street'], 'required', 'message' => '街道不能为空。例：1 queen street'],
            [['post'], 'required', 'message' => '邮编不能为空.'],
            [['country'], 'required', 'message' => '居住国家不能为空.'],
            [['city'], 'required', 'message' => '居住城市不能为空.'],
            [['state'], 'required', 'message' => '居住州/省不能为空.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%resident}}';
    }

    /**
     * {@inheritdoc}
     */
    public static function ClassName()
    {
        return 'Resident';
    }
}