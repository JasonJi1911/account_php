<?php

/**
 * 通用帮助类
 */
namespace common\helpers;

use yii\web\Response;
use yii;

class Tool
{
    /**
     * 获取请求ip地址
     * @return string
     */
    public static function getIp()
    {
        $ip = '';
        $ip_client = getenv('HTTP_CLIENT_IP') ? getenv('HTTP_CLIENT_IP') : '';
        $ip_x = getenv('HTTP_X_FORWARDED_FOR') ? getenv('HTTP_X_FORWARDED_FOR') : '';
        if ($ip_x) {
            $address = explode(",", $ip_x);
            $ip_x = $address[sizeof($address)-1];
        }
        $ip_remote = getenv('REMOTE_ADDR') ? getenv('REMOTE_ADDR') : '';

        if(!empty($ip_client) && filter_var($ip_client, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE) !== false) {
            $ip = $ip_client;
        }

        if(empty($ip) && ! empty($ip_x) && filter_var($ip_x, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE) !== false) {
            $ip = $ip_x;
        }

        if(empty($ip) && ! empty($ip_remote) && filter_var($ip_remote, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE) !== false) {
            $ip = $ip_remote;
        }

        //ip
//        if (!$ip) {
//            if (isset($_SERVER['REMOTE_ADDR'])) {
//                $ip = $_SERVER['REMOTE_ADDR'];
//            } elseif (getenv($_SERVER['REMOTE_ADDR'])) {
//                $ip = getenv($_SERVER['REMOTE_ADDR']);
//            }
//        }

        return $ip;
    }

    /**
     * 获取32位随机字符串
     * @return string
     */
    public static function getRandKey()
    {
        return md5( time() . mt_rand(0, 99999999) );
    }

    /**
     * 获取随机6位数字
     * @return int
     */
    public static function getRandNum()
    {
        return rand(100000, 999999);
    }

    /**
     * 获取MD5加密串
     * @param $param
     * @param string $glue
     * @return string
     */
    public static function getMdKey($param, $glue=''){

        return md5(implode($glue, $param));
    }

    /**
     * 数据签名方法
     * @param string $appKey
     * @param array  $params
     * @param string $secretKey
     * @param bool   $encode
     * @return array
     */
    public static function getSign($appKey, $params, $secretKey, $encode = false)
    {
        ksort($params, SORT_STRING);

        $paramStr = '';
        foreach($params as $k => $value) {
            if (is_array($value)) {
                $value = implode(',', $value);
            }
            $paramStr .= $k . '=' . $value . '&';
        }

        $signStr = $appKey . rtrim($paramStr, '&') . $secretKey;
        // echo $signStr;exit;
        if ($encode) {
            $signStr = urlencode($signStr);
        }

        $sign = md5( $signStr );

        return [$sign, $signStr];
    }


    /*
     * ajax 返回
     */
    public static function responseJson($errno, $error, $data=[])
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!$data){
            $data = (object)$data;
        }

        return compact('errno', 'error', 'data');
    }

    /**
     * 金额 分转换成元
     * @param $money
     * @return string
     */
    public static function moneyFormat($money)
    {
        if(empty($money)) return 0;

        if (is_int($money / 100)) {
            return number_format($money / 100, 1);
        } else {
            return rtrim(number_format($money / 100, 2), '0');
        }
    }

    /**
     * 金额格式化(不带人民币符号)
     * @param $money
     * @return string
     */
    public static function moneyFormatNew($money)
    {
        if(empty($money)) return '0.00';

        return number_format($money / 100, 2, '.', ',');
    }

    /**
     * 金额转换 分 ==> 元(带人民币符号)
     * @param $money
     * @return string
     */
    public static function moneyFormatYuan($money)
    {
        if(empty($money)) return '￥'.'0.00';

        return '￥'.number_format($money / 100, 2, '.', ',');
    }

    /**
     * 显示文件大小
     * @param $size
     * @return string
     */
    public static function formatSize($size)
    {
        //兼容之前按字符串填写的格式
        if (empty($size) || stripos($size, 'M') !== false) {
            return $size;
        }

        return Yii::$app->formatter->asShortSize($size, 0);
    }

    /**
     * 将数组导出csv格式，直接下载
     * @param array $arr
     * @param string $attachName
     */
    public function exportCsv($arr = [], $attachName = 'export-data')
    {
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment;filename=$attachName.csv");
        $fp = fopen('php://output', 'w');
        foreach ($arr as $row) {
            fputcsv($fp, $row);
        }
        fclose($fp);
        exit;
    }

    /**
     * 验证手机号码格式
     * @param $mobile
     * @return bool
     */
    public static function isMobile($mobile)
    {
        if (!$mobile) {
            return false;
        }

        if (strlen($mobile) != 11) {
            return false;
        }

        if (substr($mobile, 0, 1) != 1) {
            return false;
        }

        return true;
    }


    /**
     * 秒数转时间显示 >1hour 3:03:30
     * @param $seconds
     * @return string
     */
    public static function timeToLong($seconds)
    {
        if ($seconds > 3600){
            $hours = floor($seconds/3600);
            $minutes = $seconds % 3600;
            $time = $hours.":".gmstrftime('%M:%S', $minutes);
        }else{
            $time = gmstrftime('%M:%S', $seconds);
        }
        return $time;
    }

    /**
     * @param int $the_time 需要比较的时间
     * @param int $now_time 参考时间 不传时取当前时间
     * @return bool|string
     */
    public static function timeFormat($the_time, $now_time=null) {
        if ($now_time == null) {
            $now_time = time();
        }

        $dur = $now_time - $the_time;
        if ($dur < 60) {
            return $dur . '秒前';
        } else if ($dur < 3600) {
            return floor($dur / 60) . '分钟前';
        } else if ($dur < 86400) {
            return floor($dur / 3600) . '小时前';
        } else if ($dur < 259200) { //3天内
            return floor($dur / 86400) . '天前';
        } else if ($dur < 31104000){
            return date('m月d日 H:i', $the_time);
        } else {
            return date('Y年m月d日', $the_time);
        }
    }

    /**
     * 根据key清除redis缓存
     * @param $key
     */
    public static function clearCache($key)
    {
//        $redis = new RedisStore();
//        $redis->del($key);
    }

    /**
     * 批量根据key清除redis缓存
     * @param $key
     */
    public static function batchClearCache($key)
    {
//        $redis = new RedisStore();
//        $redis->delByPattern($key);
    }


    /**
     * 生产订单号
     * @param int $uid 用户uid
     * @return string
     */
    public static function makeOrderNo($uid=0)
    {
        $orderNo = date('YmdHis') . mt_rand(1000, 9999) . $uid;

        return $orderNo;
    }

    /**
     * @param       $url
     * @param array $params
     * @param int   $timeout
     * @param array $header
     * @return mixed
     */
    public static function httpGet($url, $params = [], $timeout = 10, $header=[])
    {
        $ret = [
            'errno' => 0,
            'error' => '',
            'data' => '',
            'http_code' => 0,
        ];

        if ($params) {
            $url = $url . '?' . http_build_query($params);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 QianZhuangApi/2.0");
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }

        $data = curl_exec($ch);

        $httpStatus = curl_getinfo($ch);
        $ret['http_code'] = $httpStatus['http_code'];

        if (empty($data)) {
            $ret['errno'] = 1;
            $ret['error'] = curl_error($ch);
        } else {
            $ret['data'] = $data;
        }
        curl_close($ch);

        return $ret;
    }

    public static function httpPost($url, $data, $type = 'form', $timeout = 5)
    {
        $ret = [
            'errno' => 0,
            'error' => '',
            'data' => '',
            'http_code' => 0,
        ];

        if ($type == 'raw') {
            $post_data = http_build_query($data);
        } elseif ($type == 'json') {
            $post_data = json_encode($data);
            // 中文乱码解析
            if (isset($data['msgtype']) && in_array($data['msgtype'], ['news', 'text'])) {
                $post_data = urldecode($post_data);
            }
        } elseif ($type == 'header_auth') {
            $header_auth_token = $data['header_auth_token'];
            unset($data['header_auth_token']);
            $post_data = json_encode($data);
        } else {
            $post_data = $data;
        }

        $ch = curl_init();

        if ($type == 'json') {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Content-Length: ' . strlen($post_data)));
        }

        if ($type == 'header_auth') {
            $header_auth_token_str = 'Authorization:' . $header_auth_token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept:application/json', $header_auth_token_str));
        }

        curl_setopt ( $ch,CURLOPT_TIMEOUT, $timeout);
        //curl_setopt ( $ch,CURLOPT_VERBOSE, 1);
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 QianZhuangApi/2.0");
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );

        $data = curl_exec($ch);

        $httpStatus = curl_getinfo($ch);
        $ret['http_code'] = $httpStatus['http_code'];

        if (empty($data)) {
            $ret['errno'] = 1;
            $ret['error'] = curl_error($ch);
        } else {
            $ret['data'] = $data;
        }
        curl_close($ch);

        return $ret;
    }

    public static function httpGetProxy($url, $proxyIp, $proxyPort)
    {
        // 要访问的目标页面
        $targetUrl = $url;

        // 代理服务器
        $proxyServer = "http://".$proxyIp.":".$proxyPort;;

        // 隧道身份信息
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $targetUrl);

        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, false);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // 设置代理服务器
        curl_setopt($ch, CURLOPT_PROXYTYPE, 0); //http

        // curl_setopt($ch, CURLOPT_PROXYTYPE, 5); //sock5

        curl_setopt($ch, CURLOPT_PROXY, $proxyServer);

        // 设置隧道验证信息
        curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);

        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727;)");

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);

        curl_setopt($ch, CURLOPT_TIMEOUT, 5);

        curl_setopt($ch, CURLOPT_HEADER, true);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        curl_close($ch);

        // var_dump($result);
    }

    /**
     * 临时设置日志文件,位置为默认日志文件同目录下
     * @param $fileName
     * @return bool
     */
    public static function setLogFile($fileName)
    {
        $logFile = Yii::$app->log->targets[0]->logFile;
        if (isset($logFile)) {
            $rpos = strrpos($logFile, '/');
            $path = substr($logFile, 0, $rpos); //日志路径
            Yii::$app->log->targets[0]->logFile = $path . '/' . $fileName; //拼接设置新的日志
            return true;
        }

        return false;
    }

    /**
     * 获取随机4位数字
     * @return int
     */
    public static function getRandNumFour()
    {
        return rand(1000, 9999);
    }

    /**
     * 验证邮箱格式
     * @param $email
     * @return bool
     */
    public static function isEmail($email)
    {
        $pattern = "/^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/";

        if (!preg_match($pattern, $email)) {
            return false;
        }

        return true;
    }

    /**
     *  生成指定长度的随机字符串(包含大写英文字母, 小写英文字母, 数字)
     * @param int $length 需要生成的字符串的长度
     * @return string 包含 大小写英文字母 和 数字 的随机字符串
     */
    public static function random_str($length)
    {
        //生成一个包含 大写英文字母, 小写英文字母, 数字 的数组
        $arr = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));

        $str = '';
        $arr_len = count($arr);
        for ($i = 0; $i < $length; $i++)
        {
            $rand = mt_rand(0, $arr_len-1);
            $str.=$arr[$rand];
        }

        return $str;
    }

    /**
     * 获取图片宽高
     * @param string $imgUrl
     * @return array
     */
    public static function getImageInfo($imgUrl)
    {
        $width = 0;
        $height = 0;
        if (strpos($imgUrl, 'https://') !== false || strpos($imgUrl, 'http://') !== false) {
            $ch = curl_init($imgUrl);
            // 超时设置
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            // 取前面 168 个字符 通过四张测试图读取宽高结果都没有问题,若获取不到数据可适当加大数值
            curl_setopt($ch, CURLOPT_RANGE, '0-167');
            // 跟踪301跳转
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            // 返回结果
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $dataBlock = curl_exec($ch);
            curl_close($ch);
            if ($dataBlock) {
                // 将读取的图片信息转化为图片路径并获取图片信息,经测试,这里的转化设置 jpeg 对获取png,gif的信息没有影响,无须分别设置
                // 有些图片虽然可以在浏览器查看但实际已被损坏可能无法解析信息
                $size = getimagesize('data://image/jpeg;base64,'. base64_encode($dataBlock));
                if ($size) {
                    $width = $size[0];
                    $height = $size[1];
                }
            }
        } else if (Yii::$app->setting->get('oss.save_type') == 'local') {
            list($width, $height) = getimagesize(getcwd().'/../../uploads/'.$imgUrl);
        } else {
            $imgUrl = OssUrlHelper::set($imgUrl)->toUrl() . '?x-oss-process=image/info';
            $data = static::httpGet($imgUrl);
            $imgInfo = json_decode($data['data'], true);
            $width = $imgInfo['ImageWidth']['value'];
            $height = $imgInfo['ImageHeight']['value'];
        }

        return ['width' => intval($width), 'height' => intval($height)];
    }

    /**
     * 生成唯一字符串（6位）
     * @param $seed  种子数
     * @return string
     */
    public static function makeRandStr($seed)
    {
        $code = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $rand = $code[rand(0, 25)]
            .strtoupper(dechex(date('m')))
            .date('d').substr(time(),-5)
            .substr(microtime(),2,5)
            .sprintf('%02d',rand(0,99))
            .$seed;
        for(
            $a = md5( $rand, true ),
            $s = '0123456789ABCDEFGHIJKLMNOPQRSTUV',
            $d = '',
            $f = 0;
            $f < 6; // 长度（目前6位）
            $g = ord( $a[ $f ] ),
            $d .= $s[ ( $g ^ ord( $a[ $f + 8 ] ) ) - $g & 0x1F ],
            $f++
        );

        return  $d;
    }

    /**
     * 去登录
     */
    public static function goLogin()
    {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')) {
            exit('<script>window.webkit.messageHandlers.login.postMessage(JSON.stringify({}));</script>');
        } else {
            exit('<script>decoObject.login(JSON.stringify({}));</script>');
        }
    }

    /**
     * 把秒数转换为时分秒的格式 00:10:30
     * @param Int $time 时间，单位 秒
     * @param string $str 分隔符
     * @return String
     */
    public static function secToTime($time, $str = ':'){
        $result = '00:00:00';

        if ($time>0) {
            $hour   = floor($time/3600);
            $minute = floor(($time-3600 * $hour)/60);
            $second = floor((($time-3600 * $hour) - 60 * $minute) % 60);

            if(strlen($minute) == 1) {
                $minute = '0'.$minute;
            }
            if(strlen($second) == 1) {
                $second = '0'.$second;
            }
            if(strlen($hour) == 1) {
                $hour = '0'.$hour;
            }
            $result = $hour . $str .$minute . $str . $second;
        }
        return $result;
    }

    /**
     * 根据输入的key重新排序
     * @param $arr
     * @param $keys
     * @return array
     */
    public static function arrKeySort(array $arr, array $keys)
    {
        $data = []; //最终返回

        foreach ($keys as $key) {  //遍历要排序的key
            if (!isset($arr[$key])) { //数据不存在则跳过
                continue;
            }

            $data[$key] = $arr[$key];
        }

        return $data;
    }

    /**
     * 数组映射
     * @param array $data 原数组
     * @param array $relation 映射关系
     * @return array
     */
    public static function arrMap(array $data, array $relation)
    {
        foreach ($relation as $key => $value) {
            $data[$key] = $data[$value];  // key为映射后的字段
            unset($data[$value]); // 去掉映射前的值
        }

        return $data;
    }

    /**
     * 根据传入字段来过滤值
     * @param array $array
     * @param array $fields
     * @return array
     */
    public static function filter($array, $fields)
    {
        if (empty($array) || empty($fields)) {  //直接返回
            return $array;
        }

        foreach ($array as &$arr) {
            foreach ($arr as $key => $val) {
                if (!in_array($key, $fields)) {
                    unset($arr[$key]);
                }
            }
        }

        return $array;
    }

    /**
     * 转换性别
     * @param $gender
     * @return int
     */
    public static function transGender($gender)
    {
//        if ($gender == 1) {
//            return User::GENDER_MALE;
//        } else if ($gender == 2) {
//            return User::GENDER_FEMALE;
//        }

        return 0;
    }

    /**
     * 漫画图片存储路径
     * @param int $comicId
     * @return string
     */
    public static function getComicImgDir($comicId) {
        $dir = 'comic/image/'.$comicId.'/';

        return $dir;
    }


    /**
     * 将文本转换成html版
     * @param $text
     * @return string
     */
    public static function html_text_content($text) {
        $text = mb_ereg_replace ( "\n", "</p><p style='text-indent: 2em;'>", $text);
        $text = mb_ereg_replace ( "\t", "", $text);

        $text = "<p style='text-indent: 2em;'>" . $text . '</p>';
        return $text;
    }

    /**
     * 入库转时间戳 1-45-30
     * @param $strTime
     * @return float|int
     */
    public static function strToSecond($strTime)
    {
        if (is_numeric($strTime) || empty($strTime)) {
            return $strTime;
        }
        $durationTime = preg_split('/[-|:|：]/', str_replace('：', ':', $strTime));

        $hour   = isset($durationTime[count($durationTime) - 3]) ? $durationTime[count($durationTime) - 3] : 0;
        $minute = isset($durationTime[count($durationTime) - 2]) ? $durationTime[count($durationTime) - 2] : 0;
        $second = isset($durationTime[count($durationTime) - 1]) ? $durationTime[count($durationTime) - 1] : 0;
        return  $hour * 3600 + $minute * 60 + $second;

    }

    /**
     * 移动端判断
     * @return bool
     */
    public static function isMobileClient()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备
        if (isset ($_SERVER['HTTP_VIA'])) {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT'])) {
            $clientKeywords = ['nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips','panasonic','alcatel','lenovo',
                'iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap',];
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientKeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT']))
        {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
            {
                return true;
            }
        }
        return false;
    }

    /**
     * 格式化热度值
     * @param $totalViews
     * @param $tplId
     * @return string
     */
    public static function formatTotalViews($totalViews, $tplId = 1) {
        $hot = intval($totalViews * 1);

        if ($hot > 10000) {
            $hot = round($hot/10000, 2).'万+';
        }

        if ($tplId == 1) {
            return $hot;
        }

        return '热度:'. $hot;
    }

    public static function mac_buildregx($regstr,$regopt)
    {
        return '/'.str_replace('/','\/',$regstr).'/'.$regopt;
    }

    // CurlPOST数据提交-----------------------------------------
    public static function mac_curl_post($url,$data,$heads=array(),$cookie='')
    {
        $ch = @curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLINFO_CONTENT_LENGTH_UPLOAD,strlen($data));
        curl_setopt($ch, CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        if(!empty($cookie)){
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        if(count($heads)>0){
            curl_setopt ($ch, CURLOPT_HTTPHEADER , $heads );
        }
        $response = @curl_exec($ch);
        if(curl_errno($ch)){//出错则显示错误信息
            //print curl_error($ch);
        }
        curl_close($ch); //关闭curl链接
        return $response;//显示返回信息
    }
// CurlGet数据提交-----------------------------------------
    public static function mac_curl_get($url,$heads=array(),$cookie='')
    {
        $ch = @curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36');

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
        if(!empty($cookie)){
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        if(count($heads)>0){
            curl_setopt ($ch, CURLOPT_HTTPHEADER , $heads );
        }
        $response = @curl_exec($ch);
        if(curl_errno($ch)){//出错则显示错误信息
            //print curl_error($ch);die;
        }
        curl_close($ch); //关闭curl链接
        return $response;//显示返回信息
    }

    /*
    *功能：php完美实现下载远程图片保存到本地
    *参数：文件url,保存文件目录,保存文件名称，使用的下载方式
    *当保存文件名称为空时则使用远程文件原来的名称
    */
    public static function getImage($url,$save_dir='',$filename='',$type=0){
        if(trim($url)==''){
            return array('file_name'=>'','save_path'=>'','error'=>1);
        }
        if(trim($save_dir)==''){
            $save_dir='./';
        }
        if(trim($filename)==''){//保存文件名
            $ext=strrchr($url,'.');
            if($ext!='.gif'&&$ext!='.jpg'){
                return array('file_name'=>'','save_path'=>'','error'=>3);
            }
            $filename=time().$ext;
        }
        if(0!==strrpos($save_dir,'/')){
            $save_dir.='/';
        }
        //创建保存目录
        if(!file_exists($save_dir)&&!mkdir($save_dir,0777,true)){
            return array('file_name'=>'','save_path'=>'','error'=>5);
        }
        //获取远程文件所采用的方法
        if($type){
            $ch=curl_init();
            $timeout=300;
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
            $img=curl_exec($ch);
            curl_close($ch);
        }else{
            ob_start();
            readfile($url);
            $img=ob_get_contents();
            ob_end_clean();
        }
        //$size=strlen($img);
        //文件大小
        $fp2=@fopen($save_dir.$filename,'a');
        fwrite($fp2,$img);
        fclose($fp2);
        unset($img,$url);
        return array('file_name'=>$filename,'save_path'=>$save_dir.$filename,'error'=>0);
    }
}

