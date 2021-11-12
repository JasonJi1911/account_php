<?php

namespace common\models;

use common\behaviors\UploadBehavior;
use phpDocumentor\Reflection\Types\This;
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
 * @property string $picture
 * @property integer $created_at
 * @property integer $updated_at
 */

class Identity extends ActiveRecord
{
    const TYPE_NATIONALCARD = 'NationalCard'; // 身份证/Photo ID
    const TYPE_PASSPORT = 'Passport'; // 护照
    const TYPE_DRIVERSLICENSE = 'DriversLicense'; // 驾照

    public static $types = [
        self::TYPE_DRIVERSLICENSE => '澳洲驾照（推荐）',
        self::TYPE_NATIONALCARD => '澳洲Photo ID',
        self::TYPE_PASSPORT => '澳洲护照',
    ];

    public function rules()
    {
        return [
            [['issue_country'], 'required', 'message' => '签发国家不能为空'],
            [['type'], 'required', 'message' => '证件类型不能为空.'],
            [['number'], 'required', 'message' => '证件号码不能为空.'],
            [['issue_state'], 'required', 'message' => '签发州省不能为空.'],
            [['expiration'], 'required', 'message' => '过期时间不能为空.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['upload'] = [
            'class'  => UploadBehavior::className(),
            'config' => [
                'picture' => [
                    'extensions' => UploadBehavior::$imageExtensions,
                    'maxSize'    => 1024 * 1024 * 10 , // 10M
                    'required'   => true,
                    'dir'        => 'identity/'.$this->Customer_id.'/',
                ]
            ],
        ];

        return $behaviors;
    }

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