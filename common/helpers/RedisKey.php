<?php

namespace common\helpers;

use Yii;

/**
 * redis key 信息类
 * Class RedisKey
 * @package common\helpers
 */
class RedisKey
{
    const CACHE_SETTING_PREFIX = 'setting_%s_%s'; // 系统设置

    const API_LOCK_PREFIX = 'api_lock_%s'; //接口请求锁

    const API_STATISTICS_REQUEST    = 'api_statistics_request'; // 接口统计详情

    const API_CACHE_PREFIX = 'api_cache_prefix_%s'; //接口缓存

    const USER_STAT = 'user_stat'; //日活

    // 脚本相关
    const SCRIPT_BOOK_VIEWS = 'script_book_views'; // 书籍观看次数
    const SCRIPT_COMIC_VIEWS = 'script_comic_views';

    const MARKET_CHANNEL      = 'market_channel'; // 市场渠道

    // 用户
    const USER_INFO_PREFIX   = 'user_info_%d_%d'; //用户信息
    const TASK_INFO          = 'task_info'; // 任务信息

    // 视频
    const VIDEO_BANNER        = 'video_banner_%d';      // 视频分类信息
    const VIDEO_BANNER_PRODUCT = 'video_banner_product_%d';    //banner分端信息
    const CHANNEL_RECOMMEND   = 'channel_recommend_%d';   // 视频频道推荐位
    const RECOMMEND_INFO      = 'recommend_info_%d'; // 视频推荐位信息
    const VIDEO_AREA          = 'video_area';        // 视频地区
    const VIDEO_YEAR          = 'video_year';           // 视频年代
    const ACTOR_INFO          = 'actor_info_%d';        // 演员信息缓存前缀
    const ACTOR_AREA          = 'actor_area'; // 演员地域
    const AREA_ACTOR          = 'area_actor_%s'; // 地域演员信息
    const TOPIC_LABEL         = 'topic_label_%d';       // 栏目专题信息
    const VIDEO_CATEGORY      = 'video_category';       // 视频分类信息
    const VIDEO_RANK_LIST     = 'video_list_%s';        // 排行榜
    const TOPIC_VIDEO_LIST    = 'topic_video_list_%s';  // 专题影视,分页
    const VIDEO_FILTER_LIST   = 'video_filter_list_';   // 视频筛缓存
    const VIDEO_USER_FAVORITE = 'video_user_favorite_%d'; //用户收藏
    const REFRESH_VIDEO       = 'refresh_video_%s';       // 换一换
    const VIDEO_SOURCE        = 'video_source';           // 视频源
    const VIDEO_SHANNEL_SOURCE = 'video_channel_source_%d'; // 新增渠道区分视频源
    const VIDEO_COMMENT       = 'video_comment_%s';  // 评论
    const TOPIC_LIST          = 'TOPIC_LIST_%s'; // 专题列表
    const SEARCH_HOT_WORD     = 'search_hot_word'; // 热词
    const VIDEO_CHAPTER       = 'video_chapter_%d'; // 视频剧集

    const VIDEO_INFO_PREFIX   = 'video_info_prefix_%d'; // 视频系列前缀

    const RECOMMEND_VIDEO   = 'recommend_video_%d'; // 栏目影视信息

    // 注销锁
    const CANCEL_ACCOUNT_LOCK = 'cancel_account_lock_%s';

    //脚本定时处理数据相关key
    const SCRIPT_VIDEO_VIEWS  = 'script_series_views';
    const SCRIPT_COMMENT_LIKE = 'script_comment_like';
    const SCRIPT_ADVERT_CLICK = 'script_advert_click';
    const SCRIPT_EXECUTE_LOCK = 'script_execute_lock_%s';

    const PAY_CHANNEL = 'pay_channel';

    // 广告key
    const ADVERT_POSITION  = 'advert_position';
    const ADVERT_INFO      = 'advert_info_%d';
    const SCRIPT_ADVERT_PV = 'script_advert_pv';


    // app 配置相关
    const APPS_SETTING = 'apps_setting_%s';
    const MESSAGE_LIMIT = 'message_limit_%s'; // 短信次数限制,用于防刷
    const MESSAGE_CODE_PREFIX = 'mobile_code_%s'; // 短信验证码


    //获取设置相关key,key是设置的组名 extParam是补充参数 适用一个配置表里面会有多组配置(多配置和马甲包配置)
    public static function getSettingKey($key, $extParam=[])
    {
        $extKey = '';
        foreach ($extParam as $k => $v) {
            $extKey .= $k.'-'.$v;
        }

        return sprintf(self::CACHE_SETTING_PREFIX, $key, $extKey);
    }
    //分app的配置项(已弃用,和 getSettingKey合并使用了)
    public static function appsSettingKey($key, $appId)
    {
        return sprintf(self::APPS_SETTING, $key . '_' . $appId);
    }
    // 用户统计
    public static function userStat($date)
    {
        return self::USER_STAT . $date;
    }

    //获取接口请求锁
    public static function getApiLockKey($route, $params = [])
    {
        $key = $route . http_build_query($params);
        return sprintf(self::API_LOCK_PREFIX, md5($key));
    }

    //接口缓存key
    public static function getApiCacheKey($md5) {
        return sprintf(self::API_CACHE_PREFIX, $md5);
    }

    //接口详情
    public static function listApiRequest()
    {
        return self::API_STATISTICS_REQUEST;
    }

    //用户信息
    public static function userInfo($uid)
    {
        return sprintf(self::USER_INFO_PREFIX, date('Ymd'), $uid);
    }
    // 任务信息
    public static function taskInfo()
    {
        return self::TASK_INFO;
    }

    // app 市场渠道
    public static function marketChannel()
    {
        return sprintf(self::MARKET_CHANNEL);
    }

    // 获取频道banner设置相关key,key是频道id
    public static function videoBanner($channelId)
    {
        return sprintf(self::VIDEO_BANNER, $channelId);
    }

    // 获取频道banner设置相关key,key是频道id
    public static function videoBannerProduct($channelId)
    {
        return sprintf(self::VIDEO_BANNER_PRODUCT, $channelId);
    }

    //获取频道推荐位id
    public static function channelRecommend($channelId)
    {
        return sprintf(self::CHANNEL_RECOMMEND, $channelId);
    }
    //推荐位信息
    public static function recommendInfo($recommendId)
    {
        return sprintf(self::RECOMMEND_INFO, $recommendId);
    }
    //获取频道推荐位影片信息
    public static function recommendVideo($recommendId)
    {
        return sprintf(self::RECOMMEND_VIDEO, $recommendId);
    }
    //视频系列id
    public static function videoInfoPrefix($videoId)
    {
        return sprintf(self::VIDEO_INFO_PREFIX, $videoId);
    }
    //获取视频地区信息
    public static function videoArea()
    {
        return self::VIDEO_AREA;
    }
    //获取视频年代信息
    public static function videoYear()
    {
        return self::VIDEO_YEAR;
    }
    //演员信息
    public static function actorInfo($actorId)
    {
        return sprintf(self::ACTOR_INFO, $actorId);
    }
    //获取频道推荐位影片信息
    public static function topicLabel($channelId)
    {
        return sprintf(self::TOPIC_LABEL, $channelId);
    }

    //获取视频分类设置相关key,key是设置的组名
    public static function videoCategory()
    {
        return self::VIDEO_CATEGORY;
    }

    //获取专题影片
    public static function topicVideoList($topicId, $page)
    {
        return sprintf(self::TOPIC_VIDEO_LIST, $topicId . '_' . $page);
    }
    // 视频筛选页
    public static function videoFilterList($param)
    {
        return self::VIDEO_FILTER_LIST . md5(http_build_query($param));
    }
    //影片剧集key
    public static function videoChapter($videoId)
    {
        return sprintf(self::VIDEO_CHAPTER, $videoId);
    }
    //用户收藏
    public static function videoUserFavorite($uid)
    {
        return sprintf(self::VIDEO_USER_FAVORITE, $uid);
    }
    // 换一换
    public static function refreshVideo($key)
    {
        return sprintf(self::REFRESH_VIDEO, md5($key));
    }
    // 视频源信息
    public static function videoSource()
    {
        return self::VIDEO_SOURCE;
    }

    // 分端视频源信息 新增方法
    public static function videoShannelSource($channelId)
    {
        return  sprintf(self::VIDEO_SHANNEL_SOURCE, $channelId);
    }

    // 书籍评论
    public static function videoComment($videoId, $chapterId, $page)
    {
        return sprintf(self::VIDEO_COMMENT, $videoId . '_' . $chapterId .'_' . $page);
    }

    // 专题列表
    public static function topicList($channelId, $page)
    {
        return sprintf(self::TOPIC_LIST, $channelId . '_' .$page);
    }

    // 搜索页热词信息
    public static function searchHotWord()
    {
        return self::SEARCH_HOT_WORD;
    }

    //所有广告位置信息
    public static function advertPosition()
    {
        return self::ADVERT_POSITION;
    }
    //根据广告id获取广告信息key
    public static function advertInfoKey($advertId)
    {
        return sprintf(self::ADVERT_INFO, $advertId);
    }

    //------获取脚本处理数据

    //视频观看数
    public static function scriptVideoViews()
    {
        return self::SCRIPT_VIDEO_VIEWS;
    }
    //评论点赞数
    public static function scriptCommentLike()
    {
        return self::SCRIPT_COMMENT_LIKE;
    }
    // 广告pv数
    public static function scriptAdvertPv()
    {
        return self::SCRIPT_ADVERT_PV;
    }

    //取支付渠道key
    public static function getPayChannelKey() {
        return self::PAY_CHANNEL;
    }

    public static function scriptAdvertClick()
    {
        return self::SCRIPT_ADVERT_CLICK;
    }

    // 短信次数
    public static function messageLimit($ip)
    {
        return sprintf(self::MESSAGE_LIMIT, $ip);
    }
    // 短信验证码
    public static function messageCode($mobile)
    {
        return sprintf(self::MESSAGE_CODE_PREFIX, $mobile);
    }

    // 脚本锁
    public static function scriptExecuteLock($route)
    {
        return sprintf(self::SCRIPT_EXECUTE_LOCK, md5($route));
    }

    // 影视排行，修改排行和删除影视的时候需要清理
    public static function videoRankList($rankId, $period, $isAdmin = false)
    {
        if ($isAdmin) {
            return sprintf(self::VIDEO_RANK_LIST, '');
        }

        $pageNum = Yii::$app->request->post('page_num', 1);
        $params = http_build_query(['rank_id' => $rankId, 'period' => $period, 'page_num' => $pageNum]); // 请求参数
        return sprintf(self::VIDEO_RANK_LIST, md5($params));
    }

    // 所有演员的地域
    public static function actorArea()
    {
        return self::ACTOR_AREA;
    }
    // 地域下的演员
    public static function areaActor($areaId, $pageNum, $pageSize)
    {
        return sprintf(self::AREA_ACTOR, $areaId . '_' . $pageNum . '_' . $pageSize);
    }
    /**
     * 注销锁
     * @param $udid
     * @return string
     */
    public static function getCancelAccountLock($udid)
    {
        return sprintf(self::CANCEL_ACCOUNT_LOCK, $udid);
    }
}
