<?php

namespace common\behaviors;

use common\models\advert\Advert;
use Yii;
use yii\base\Behavior;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\validators\FileValidator;
use common\helpers\OssHelper;
use common\helpers\OssUrlHelper;
use yii\base\Event;

/**
 * 上传行为
 */
class UploadBehavior extends Behavior
{
    /**
     * @var array
     */
    public $config = [];
    /**
     * @var array
     */
    public static $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'pdf'];

    public static $textExtensions = ['txt'];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->config)) {
            throw new InvalidParamException('config property is must be set.');
        }
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function events()
    {
        return [
            // 插入和更新前，上传文件
            ActiveRecord::EVENT_BEFORE_INSERT => 'upload',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'upload',

            // 获取后，包装文件
            ActiveRecord::EVENT_AFTER_FIND => 'wrapper',
        ];
    }

    /**
     * 上传文件
     * @param Event $event
     */
    public function upload($event)
    {
        $model = $event->sender;
        $oss   = new OssHelper();

        // 默认配置
        $default = [
            'required' => false,
            'tooBig' => '文件大小不能超过{formattedLimit}.',
        ];

        foreach ($this->config as $attribute => $config) {

            // 合并配置
            $config = array_merge($default, $config);

            // 是否必须?
            $required = $config['required'];
            unset($config['required']);

            // 上传目录
            $dir = '';
            if (isset($config['dir'])) {
                $dir = rtrim($config['dir'], '/') . '/';
                unset($config['dir']);
            }

            // 获取上传的文件
            $file = UploadedFile::getInstance($model, $attribute);

            // 如果上传文件为空，并且该属性不是必须的，或者该属性已经设置了，跳过

            if (!$file && (!$required || $model->$attribute)) {
                // 如果是已经设置好了图片属性，没有修改，则把值重置为初始状态
                if ($model->$attribute instanceof OssUrlHelper) {
                    $model->$attribute = $model->$attribute->getBaseUrl();
                }
                continue;
            }

            // 否则去验证
            if ($model->$attribute && !(new FileValidator($config))->validate($file, $error)) {
                $model->addError($attribute, $error);
                $event->isValid = false;
                return;
            }

            // 上传文件
            if ($file) {
                //文件名
                $filename = md5(time().rand(10000, 99999)).'.'.$file->extension;
                $imgPath = $dir . $filename;

                if (!$oss->uploadFile($file->tempName, $imgPath)) {
                    $model->addError($attribute, '文件上传失败，请稍后再试');
                    $event->isValid = false;
                    return;
                }

                if($model instanceof Advert)
                    $model->$attribute = ADVERTURL.$imgPath;
                else
                    $model->$attribute = $imgPath;
            }
        }
    }

    /**
     * 包装文件
     * @param Event $event
     */
    public function wrapper($event)
    {
        $model = $event->sender;

        foreach (array_keys($this->config) as $attribute) {
            $model->$attribute = OssUrlHelper::set($model->$attribute);
        }
    }
}
