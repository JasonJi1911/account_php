<?php

namespace common\models;
use common\helpers\Tool;

/**
 * Candidate model
 *
 * @property integer $Customer_id
 * @property integer $employer_name
 * @property string $occupation
 * @property string $employer_business
 * @property string $street_2
 * @property string $street_1
 * @property string $postal_code
 * @property string $country
 * @property string $city
 * @property string $state
 * @property string $affiliation
 * @property string $affliation_relationship
 * @property string $affliation_name
 * @property string $affiliation_company
 * @property string $affiliation_company_email
 * @property string $affiliation_company_phone
 * @property string $affiliation_company_address
 * @property string $affiliation_company_city
 * @property string $affiliation_company_state
 * @property string $affiliation_company_country
 * @property string $affiliation_company_postcode
 */
class Employment extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            [['employer_name'], 'required', 'message' => '雇佣单位不能为空'],
            [['occupation'], 'required', 'message' => '职位不能为空.'],
            [['employer_business'], 'required', 'message' => '商业性质不能为空.'],
            [['street_1'], 'required', 'message' => '公司地址不能为空.'],
            [['city'], 'required', 'message' => '公司所在城市不能为空.'],
            [['state'], 'required', 'message' => '公司所在州不能为空.'],
            [['country'], 'required', 'message' => '公司所在国家不能为空.'],
            [['postal_code'], 'required', 'message' => '邮编不能为空.'],
            [
                [
                    'affliation_relationship', 'affliation_name', 'affiliation_company'
                    , 'affiliation_company_email', 'affiliation_company_phone', 'affiliation_company_address'
                    , 'affiliation_company_city', 'affiliation_company_state', 'affiliation_company_country'
                    , 'affiliation_company_postcode'
                ]
                , 'validateAffiliation'
                , 'skipOnEmpty' => false
            ]
        ];
    }

    public function validateAffiliation($attribute, $params)
    {
        $code = $this->$attribute;

        if ($this->affiliation == 1)
        {
            if (!$code) {
                $this->addError($attribute, '监管信息不能为空.');
            }
        }
    }
}