<?php

namespace frontend\services;

use common\helpers\Tool;
use Yii;
use yii\base\UnknownMethodException;

/**
 * 接口服务
 */
class ApiService
{
    /**
     * @var integer 超时时间
     */
    public $timeout = 30;
    /**
     * @var integer 最大重试次数
     */
    public $maxRetryTimes = 3;

    /**
     * 魔术方法
     */
    public function __call($method, array $params)
    {
        if (substr($method, 0, 3) == 'get') {
            $path = preg_replace_callback('/[A-Z]/', function ($matches) {
                return '/' . strtolower($matches[0]);
            }, substr($method, 3));


            return call_user_func([$this, 'get'], $path, $params[0] ?? []);
        }

        throw new UnknownMethodException('Calling unknown method: ' . get_class($this) . "::$name()");
    }

    /**
     * @param       $path
     * @param array $params
     * @param bool  $return_code 当返回值错误时,返回错误信息
     * @param int   $timeout
     * @return bool
     */
    public function get($path, array $params = [], $return_code = false, $timeout = 30)
    {
//        if (stripos(Yii::$app->request->userAgent, 'ios') !== false) {
//            $osType = 1;
//        } elseif (stripos(Yii::$app->request->userAgent, 'android') !== false) {
//            $osType = 2;
//        } else {
//            $osType = 0;
//        }
        $osType = 0;

        //设置page
        $page = Yii::$app->request->get('page');
        if ($page) {
            $params['page_num'] = $page;
        }

        //传了token使用传入的token,为解决token刷新的问题
        if (!isset($params['token'])) {
            $params['token'] = Yii::$app->request->cookies->getValue('user_token');
        }

        // 合并默认参数
        $params = array_merge([
            'ver'    => '1.0',
//            'osType' => $osType,
            'time'   => time(),
//            'product'=> Common::PRODUCT_PC,
            'debug' => 1,
            'ip' => Tool::getIp(),
        ], $params);

        // 签名
//        $config = Common::getSecretKey($params['product'], $params['osType']);
//        list($appKey, $secret) = array_values($config);
//        $sign = Tool::getSign($appKey, $params, $secret);
//        $params['sign'] = $sign[0];

        // 发送请求
        $url = API_HOST_PATH . $path;

        $result = null;

        $times = 0;
        while ($times++ < $this->maxRetryTimes) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout ?: $this->timeout);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
            $result = curl_exec($ch);
            curl_close($ch);
            // 请求成功，跳过循环
            if ($result) {
                break;
            }
        }

        // 接口请求失败
        $result = json_decode($result, true);
        if (!$result) {
            return false;
        }

        if ($return_code) {
            return [
                'code' => $result['code'],
                'msg' => $result['msg'],
                'data' => $result['data']
            ];
        }

        if ($result['code'] == 0) {
            // 接口响应成功
            return $result['data'];
        }
    }
}
