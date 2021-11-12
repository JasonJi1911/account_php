<?php

namespace common\models\setting;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%setting_oss}}".
 *
 * @property int $id
 * @property int $save_type 存储文件类型
 * @property string $bucket 存储空间名
 * @property string $server_point 地域节点
 */
class SettingOss extends ActiveRecord
{

    const SAVE_TYPE_OSS = 1; //oss
    const SAVE_TYPE_LOCAL = 2; //本地

    public static $saveTypeMap = [
        self::SAVE_TYPE_OSS => 'oss',
        self::SAVE_TYPE_LOCAL => '本地'
    ];


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%setting_oss}}';
    }
}
