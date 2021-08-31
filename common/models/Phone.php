<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * Phone model
 *
 * @property integer $Customer_id
 * @property integer $uid
 * @property string $number
 * @property string $type
 * @property string $country
 * @property integer $created_at
 * @property integer $updated_at
 */

class Phone extends ActiveRecord
{
    const COUNTRY_USA = 'USA'; // 美国
    const COUNTRY_CHINA = 'CHN'; // 中国
    const COUNTRY_AUS = 'AUS'; // 澳大利亚

    public static $countrys = [
        self::COUNTRY_CHINA => '中国',
        self::COUNTRY_USA => '美国',
        self::COUNTRY_AUS => '澳大利亚',
    ];

    public function rules()
    {
        return [
            [['number'], 'required', 'message' => '手机号不能为空'],
            [['country'], 'required', 'message' => '国家不能为空.']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%phone}}';
    }
}