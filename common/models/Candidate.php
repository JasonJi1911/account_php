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
        self::CITIZEN_CHINA => '中国',
        self::CITIZEN_USA => '美国',
        self::CITIZEN_AUS => '澳大利亚',
    ];

    const SAME_CITIZEN_YES = 1; // 是
    const SAME_CITIZEN_NO = 0; // 否

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