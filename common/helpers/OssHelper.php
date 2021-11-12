<?php
/**
 * Created by PhpStorm.
 */
namespace common\helpers;

use common\models\setting\SettingAliyun;
use common\models\setting\SettingOss;
use Yii;
use OSS\OssClient;
use OSS\Core\OssException;

class OssHelper {

    public $ossClient;

    //oss访问信息
    public $accessKeyId;
    public $accessKeySecret;

    //oss配置信息
    public $bucket;  //存储空间名,oss为bucket名称,本地为文件路径
    public $server_point;  //地域节点名称,即访问的域名

    public function __construct()
    {
        //load基础配置
        $this->accessKeyId = Yii::$app->setting->get('aliyun.access_key', ['type' => SettingAliyun::TYPE_OSS]);
        $this->accessKeySecret = Yii::$app->setting->get('aliyun.access_secret', ['type' => SettingAliyun::TYPE_OSS]);
        $this->bucket = Yii::$app->setting->get('oss.bucket');
        $this->server_point = Yii::$app->setting->get('oss.server_point');

        if (Yii::$app->setting->get('oss.save_type') == SettingOss::SAVE_TYPE_OSS) { //文件存储到oss
            // 统一走外网
            $this->ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->server_point, true);
        }
    }

    /**
     * NOTE: 上传图片至oss
     * @param file $file 本地文件地址
     * @param $object 对象存储存放地址
     * @return bool|null
     * @throws \OSS\Core\OssException
     */
    public function uploadFile($file, $object)
    {
        if (Yii::$app->setting->get('oss.save_type') == SettingOss::SAVE_TYPE_OSS) { //如果是阿里云oss存储

            try {
                $ossClient = $this->ossClient;
            } catch (OssException $e) {
                Yii::error('get_oss_client_error, msg:' . $e->getMessage());
                return false;
            }

            try {
                $file_result = $ossClient->uploadFile($this->bucket, $object , $file);
            } catch (OssException $e) {
                Yii::error('upload_to_oss_error, msg:' . $e->getMessage());
                return false;
            }

            return true;
        } else {  //图片本地存储

            $rootPath = dirname(dirname(__DIR__)) . '/uploads/'; //文件存储根路径

            if (($pos = strrpos($object, '/')) !== false) { //存储的文件夹
                $dir = substr($object, 0, $pos);
                if (!is_dir($rootPath . $dir)) {
                    @mkdir($rootPath . $dir, 0777, true);
                }
            }

            if (copy($file, $rootPath . $object)) {
                return true;
            }

            // if (move_uploaded_file($file, $rootPath . $object)) {
            //     return true;
            // }
            return false;
        }
    }

    /**
     * 上传base 64 格式图片
     * @param $file_base
     * @param $dir
     * @return bool
     */
    public function uploadFileBaseToOss($file_base, $dir)
    {
        if (empty($file_base)) {
            return false;
        }

        //临时保存二进制流文件
        if (preg_match('/^(data:\s*(image|audio)\/(\w+);base64,)/', $file_base, $match)) {
            //取扩展名
            $expand_type = $match[3];
        } else {
            Yii::warning('preg_match,(data:\s*(image|audio)\/(\w+);base64没匹配到类型');
            return false;
        }

        $time = time();
        //临时文件名
        $file_name = md5($time.rand(1000, 9999)). '.' . $expand_type;

        $path = getcwd() . '/../../uploads/';
        //检测目录 不存在时创建目录
        if (!file_exists($path)) {
            @mkdir($path, 0777, true);
        }

        $localName = $path.$file_name; // 本地文件存储路径
        file_put_contents($localName, base64_decode(str_replace($match[1], '', $file_base)));

        if ($dir) { // 拼接oss上文件路径
            $name = trim($dir, '/')  . '/' . $file_name;
        } else {
            $name = $file_name;
        }

        if ($this->uploadFile($localName, $name)) {
            @unlink($localName);
            return $name;
        }
        return false;
    }

    /**
     * NOTE: 阿里云生成图片缩略图
     * @param string $path 阿里云存放地址
     * @param array $options
     * @return bool|string 加工之后的地址
     *
     *  $options = [OssClient::OSS_PROCESS => "image/resize,m_lfit,w_480,limit_0/auto-orient,0/quality,q_50"];
     */
    public function getOssSignUrl($path, $options = [])
    {
        try {
            $ossClient =  $this->ossClient;
        } catch (OssException $e) {
            Yii::error('get_oss_client_error, msg:' . $e->getMessage());
            return false;
        }

        try {
            $signedUrl = $ossClient->signUrl($this->bucket, $path, 3600, 'GET', $options);
            //去掉签名相关
            if (strpos($signedUrl, '&OSSAccessKeyId') !== false) {
                $signedUrl = substr($signedUrl, 0, strpos($signedUrl, '&OSSAccessKeyId'));
            }

            if (strpos($signedUrl, '?OSSAccessKeyId') !== false) {
                $signedUrl = substr($signedUrl, 0, strpos($signedUrl, '?OSSAccessKeyId'));
            }

        } catch (OssException $e) {
            Yii::error('get_sign_url_error, msg:' . $e->getMessage());
            return false;
        }

        return $signedUrl;
    }


}
