<?php

namespace common\models;
/**
 * Candidate model
 *
 * @property integer $Customer_id
 * @property integer $TIN
 * @property string $country
 * @property string $TINType
 * @property string $authority
 * @property string $treaty_country
 */
class Tax extends \yii\db\ActiveRecord
{
    const TINTYPE_SSN = 'SSN'; // 是
    const TINTYPE_NonUS_NationalID = 'NonUS_NationalID'; // 否

    public function rules()
    {
        return [
            [['TIN'], 'required', 'message' => '税号不能为空'],
            [['country'], 'required', 'message' => '纳税国不能为空.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tax}}';
    }

    /**
     * {@inheritdoc}
     */
    public static function ClassName()
    {
        return 'Tax';
    }
}