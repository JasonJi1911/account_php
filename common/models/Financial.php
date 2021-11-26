<?php

namespace common\models;

use common\behaviors\UploadBehavior;
use yii\db\ActiveRecord;
use Yii;
/**
 * financial model
 *
 * @property int $Customer_id
 * @property int $net_worth
 * @property int $liquid_net_worth
 * @property int $annual_net_income
 * @property int $total_assets
 * @property string $InvestmentObjectives
 * @property string $picture
 */
class Financial extends ActiveRecord
{

    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file',  'extensions' => 'png, jpg, jpeg'],//'skipOnEmpty' => false,
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $uploadDir = Yii::$app->basePath.'/../uploads/income/';
//            if( !file_exists($uploadDir) ) {
//                if( !mkdir( $uploadDir ) ) {
//                    getjson('创建目录失败:'.$uploadDir);
//                    return;
//                }
//            }
            $this->imageFile->saveAs($uploadDir . md5($this->imageFile->baseName.$this->Customer_id) . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
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
                'dir'        => 'income/',
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
        return '{{%financial}}';
    }

    /**
     * {@inheritdoc}
     */
    public static function ClassName()
    {
        return 'Financial';
    }
}