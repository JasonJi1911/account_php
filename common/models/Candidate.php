<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * Candidate model
 *
 * @property integer $Customer_id
 * @property integer $uid
 * @property string $email
 * @property string $salutation
 * @property string $first_name
 * @property string $last_name
 * @property string $DOB
 * @property string $countryOfBirth
 * @property string $maritalStatus
 * @property integer $numDependents
 * @property string $citizenship
 * @property int $same_citizen
 * @property string $employment_type
 * @property string $status
 * @property string $step
 * @property string $external_id
 * @property integer $created_at
 * @property integer $updated_at
 */

class Candidate extends ActiveRecord
{
    const SALUTATION_MAN = 'Mr.'; // 男
    const SALUTATION_Female = 'Mrs.'; // 女
    public static $salutations = [
        self::SALUTATION_MAN => '男',
        self::SALUTATION_Female => '女',
    ];

    const CITIZEN_CHINA = 'CHN'; // 中国
    const CITIZEN_USA = 'USA'; // 美国
    const CITIZEN_AUS = 'AUS'; // 澳大利亚
    public static $citizenships = [
        self::CITIZEN_AUS => '澳大利亚',
        self::CITIZEN_CHINA => '中国',
        self::CITIZEN_USA => '美国',
    ];

    const SAME_CITIZEN_YES = 1; // 是
    const SAME_CITIZEN_NO = 0; // 否

    const EMPLOYTYPE_EMPLOYED = "EMPLOYED"; // 受雇
    const EMPLOYTYPE_RETIRED = "RETIRED"; // 退休
    const EMPLOYTYPE_SELFEMPLOYED = "SELFEMPLOYED"; // 自行创业
    const EMPLOYTYPE_UNEMPLOYED = "UNEMPLOYED"; // 失业
    const EMPLOYTYPE_STUDENT = "STUDENT"; // 学生/实习生
//    const EMPLOYTYPE_INTERN = "INTERN"; // 内部人员
    const EMPLOYTYPE_ATHOMETRADER = "ATHOMETRADER"; // 在家交易者（无其他职业）
    const EMPLOYTYPE_HOMEMAKER = "HOMEMAKER"; // 家庭主妇
    public static $employTypes = [
        self::EMPLOYTYPE_EMPLOYED => "受雇",
        self::EMPLOYTYPE_RETIRED => "退休",
        self::EMPLOYTYPE_SELFEMPLOYED => "自行创业",
        self::EMPLOYTYPE_UNEMPLOYED => "失业",
        self::EMPLOYTYPE_STUDENT => "学生/实习生",
//        self::EMPLOYTYPE_INTERN => "内部人员",
        self::EMPLOYTYPE_ATHOMETRADER => "在家交易者（无其他职业）",
        self::EMPLOYTYPE_HOMEMAKER => "家庭主妇",
    ];

    public function rules()
    {
        return [
            [['first_name'], 'required', 'message' => '名不能为空'],
            [['last_name'], 'required', 'message' => '姓不能为空.'],
            [['salutation'], 'required', 'message' => '称呼不能为空'],
            [['email'], 'required', 'message' => '邮箱不能为空.'],
            [['DOB'], 'required', 'message' => '生日不能为空.'],
            [['maritalStatus'], 'required', 'message' => '婚姻状况不能为空.'],
            [['numDependents'], 'required', 'message' => '家庭成员数量不能为空.'],
            [['employment_type'], 'required', 'message' => '雇佣状况不能为空']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%candidate}}';
    }

    /**
     * {@inheritdoc}
     */
    public static function ClassName()
    {
        return 'Candidate';
    }
}