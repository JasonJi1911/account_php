<?php

namespace frontend\services;

/**
 * 文件上传服务
 */
class UploadService
{
    /**
     * @var integer 超时时间
     */
    public $root_path = 30;
    /**
     * @var integer 最大重试次数
     */
    public $uploadPath = 3;

}