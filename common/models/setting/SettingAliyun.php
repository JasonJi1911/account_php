<?php

namespace common\models\setting;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%setting_aliyun}}".
 *
 * @property int $id
 * @property string $access_key
 * @property string $access_secret
 * @property int $type
 */
class SettingAliyun extends ActiveRecord
{
    const TYPE_OSS      = 1; // oss图片
    const TYPE_PUSH     = 2; // 推送
    const TYPE_MESSAGE  = 3; // 短信服务

    public static $typeMap = [
        self::TYPE_OSS      => 'oss',
        self::TYPE_PUSH     => '移动推送',
        self::TYPE_MESSAGE  => '消息推送'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%setting_aliyun}}';
    }
}
