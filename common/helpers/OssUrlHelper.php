<?php

namespace common\helpers;

use common\models\setting\SettingOss;
use Yii;
use OSS\OssClient;

/**
 * 阿里云图片URL生成类
 */
class OssUrlHelper
{
    const RESIZE_MODE_LFIT  = 'lfit';//等比缩放 默认   https://help.aliyun.com/document_detail/44688.html
    const RESIZE_MODE_MFIT  = 'mfit';//短边优先
    const RESIZE_MODE_PAD   = 'pad';//缩略补全
    const RESIZE_MODE_FIXED = 'fixed';//强制宽高
    const RESIZE_MODE_FILL  = 'fill';//自动裁剪
    const RESIZE_MODE_FILL_TOP = 'fill_top';//从顶部开始裁剪，实际效果等于先调用resize，再调用crop
    const RESIZE_MODE       = [
        self::RESIZE_MODE_LFIT,
        self::RESIZE_MODE_MFIT,
        self::RESIZE_MODE_PAD,
        self::RESIZE_MODE_FIXED,
        self::RESIZE_MODE_FILL,
        self::RESIZE_MODE_FILL_TOP
    ];

    const OSSPROCESS = '?' . OssClient::OSS_PROCESS . '=';
    public $ext = ['jpg', 'png', 'gif', 'webp', 'bmp'];

    /**
     * 支持的操作
     * 用法如下：
     * rounded_corners('r_39')->indexcrop('x_100','i_1');
     *
     * @var array
     */
    public         $method        = [
        'rotate',           // 图片按顺时针旋转的角度[0, 360]  默认值为 0，表示不旋转。
        'auto-orient',      // 进行自动旋转0：表示按原图默认方向，不进行自动旋转。1：先进行图片进行旋转，然后再进行缩略 [0, 1]
        'sharpen',          // 表示进行锐化处理。取值为锐化参数，参数越大，越清晰。	[50, 399] 为达到较优效果，推荐取值为 100。
        'interlace',        // 渐进显示  1 表示保存成渐进显示的 jpg 格式 0 表示保存成普通的 jpg 格式
        'bright',           // 亮度调整。0 表示原图亮度，小于 0 表示低于原图亮度，大于 0 表示高于原图亮度。	[-100, 100]
        'contrast',         // 对比度调整。0 表示原图对比度，小于 0 表示低于原图对比度，大于 0 表示高于原图对比度。	[-100, 100]
        /*
        jpg	将原图保存成jpg格式，如果原图是png、webp、bmp存在透明通道，默认会把透明填充成白色。
        png	将原图保存成png格式。
        webp	将原图保存成webp格式。
        bmp	将原图保存成bmp格式。
        gif	将gif格式保存成gif格式，非gif格式是按原图格式保存。
        */
        'format',           // 可以直接用 ->png()进行格式。
        'rounded-corners',  // r	将图片切出圆角，指定圆角的半径。	[1, 4096] 生成的最大圆角的半径不能超过原图的最小边的一半。
        'indexcrop',        // x	进行水平切割，每块图片的长度。x 参数与 y 参数只能任选其一。	[1,图片宽度] y	进行垂直切割，每块图片的长度。x 参数与 y 参数只能任选其一。	[1,图片高度]  i	选择切割后第几个块。（0表示第一块）	[0,最大块数)。如果超出最大块数，返回原图。
        'circle',           //r  从图片取出的圆形区域的半径	半径 r 不能超过原图的最小边的一半。如果超过，则圆的大小仍然是原圆的最大内切圆。
        'blur'              //模糊效果  r	模糊半径	[1,50]r  越大图片越模糊。 s	正态分布的标准差	[1,50] s 越大图片越模糊。
    ];
    private $_process  = '';
    private $_base_url = '';
    private $_width = '';

    public function __construct($url)
    {
        $this->_base_url = $url;
        $this->_process  = '';
        $this->_width  = '';
    }

    /**
     * 初始化图片URL生成类
     * @param string $url 图片的URL
     * @return OssUrlHelper
     */
    public static function set($url)
    {
        static $instances = [];

        if (!isset($instances[$url])) {
            $instances[$url] = new self($url);
        }

        return $instances[$url];
    }

    /**
     * 本类不支持的参数，可以手动拼接
     *
     * @param string $process
     * @return OssUrlHelper
     */
    public function custom($process = '')
    {
        self::$process .= $process;
        return $this;
    }

    /**
     * 图片缩放
     *
     * @param string $mode
     * @param integer $width
     * @param integer $height
     * @param integer $limit 调用resize，默认是不允许放大。即如果请求的图片对原图大，那么返回的仍然是原图。如果想取到放大的图片，即增加参数调用limit,0 （如：https://image-demo.oss-cn-hangzhou.aliyuncs.com/example.jpg?x-oss-process=image/resize,w_500,limit_0）
     * @param integer $p 倍数百分比。 小于100，即是缩小，大于100即是放大。    1-1000
     * @return OssUrlHelper
     */
    public function resize( $width = 0,  $height = 0,  $mode = self::RESIZE_MODE_LFIT,  $limit = 1, int $p = null)
    {
        if (!$width && !$height && !$p) return $this;

        $this->_width = $width;

        // 从顶部开始裁剪，等于先调用resize，再调用crop
        if ($mode == self::RESIZE_MODE_FILL_TOP) {
            $old_height = $height;
            $height = 0;
            $mode = self::RESIZE_MODE_LFIT;
        }

        $item = ['/resize'];
        ($width > 0) && array_push($item, 'w_' . $width);
        ($height > 0) && array_push($item, 'h_' . $height);
        ($limit !== 1) && array_push($item, 'limit_' . $limit);
        ($p !== null) && array_push($item, 'p_' . $p);
        ($mode !== null) && in_array($mode, self::RESIZE_MODE) && array_push($item, 'm_' . $mode);
        $this->_process = implode(',', $item);
        return !isset($old_height) ? $this : $this->crop($width, $old_height);
    }

    /**
     * 裁剪
     *
     * @param [type] $width
     * @param [type] $height
     * @param [type] $pos [nw,north,ne,west,center,east,ne]
     * @param [type] $x
     * @param [type] $y
     * @return OssUrlHelper
     */
    public function crop($width, $height, $pos = null, $x = null, $y = null)
    {
        $item = ["/crop,w_{$width},h_{$height}"];
        ($pos !== null) && array_push($item, 'g_' . $pos);
        ($x !== null && $y !== null) && array_push($item, ",x_{$x},y_{$y}");
        $this->_process .= implode(',', $item);
        return $this;
    }

    /**
     * 质量变换
     *
     * @param integer $quality
     * @param string $mode
     * @return OssUrlHelper
     */
    public function quality(int $quality, $mode = 'q') //q 相对质量， Q 绝对质量
    {
        $this->_process .= "/quality,{$mode}_{$quality}";
        return $this;
    }

    public function watermark()
    {
    }

    public function getProcess()
    {
        return 'image' . $this->_process;
    }

    public function setProcess($process)
    {
        $this->_process = $process;
        return $this;
    }

    /**
     * 获取基本信息和exif信息
     *
     * @return string
     */
    public function info()
    {
        return $this->_base_url . self::OSSPROCESS . $this->_process . '/info';
    }

    /**
     * 图片样式类型的图片
     *
     * @param [type] $style
     * @return string
     */
    public function style($style)
    {
        return $this->_base_url . self::OSSPROCESS . 'style/' . $style;
    }

    public function __toString()
    {
        return $this->toUrl();
    }


    public function toUrl()
    {
        if (!$this->_base_url) {
            return '';
        }

        //检测是否url链接 是直接返回
        if(preg_match('/^(http|https|ftp):\/\//i', $this->_base_url)) {
            return $this->_base_url;
        }

        $this->_base_url = ltrim($this->_base_url, '/');

        $options = [];

        // 如果是oss添加param参数
        if (Yii::$app->setting->get('oss.save_type') == SettingOss::SAVE_TYPE_OSS && $this->_process) {
            $options[OssClient::OSS_PROCESS] = $this->getProcess();
        }

        $this->_width = '';

        //获取地址
        $ossHelper = new OssHelper();
        if (Yii::$app->setting->get('oss.save_type') == SettingOss::SAVE_TYPE_OSS) { //阿里云oss存储
            return $ossHelper->getOssSignUrl($this->_base_url, $options);
        } else {  // 本地存储,直接用域名拼接
            return Yii::$app->setting->get('oss.server_point') . '/' . $this->_base_url;
        }
    }

    public function getBaseUrl()
    {
        return $this->_base_url;
    }

}
