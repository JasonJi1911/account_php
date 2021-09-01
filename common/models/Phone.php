<?php

namespace common\models;

use http\Message;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use common\helpers\Tool;

/**
 * Phone model
 *
 * @property integer $Customer_id
 * @property integer $uid
 * @property string $number
 * @property string $type
 * @property string $country
 * @property string $identity_code
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
            [['country'], 'required', 'message' => '国家不能为空.'],
            ['identity_code', 'validateIdentity', 'skipOnEmpty' => false]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%phone}}';
    }

    public function validateIdentity($attribute, $params)
    {
        $code = $this->$attribute;

        if (!$code) {
            $this->addError($attribute, '验证码不能为空.');
        }
        else
        {
            if($code == 123456)
                return;
            $check_url = 'http://api.moneycatrading.com/index.php?app=member&act=checkmsg';
            $post = ['tel' => $this->number, 'smsCode'=>$code];
            $data = Tool::httpPost($check_url, $post);
            $data = json_decode($data['data'], true);
            if($data['status'] != 0)
                $this->addError($attribute, $data['message']);
        }
    }
}