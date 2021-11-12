<?php

namespace common\helpers;

use Yii;
use yii\base\Component;

class RedisStore extends Component
{
    /**
     * @var \yii\redis\Connection;
     */
    public $redis; //redis实例

    const API_EXPIRE_TIME = 3600; //接口过期时间

    public function init()
    {
        parent::init();

        //默认redis实例
        $this->redis = Yii::$app->redis;
    }

    //----------------  string和通用方法 ---------------
    /**
     * 设置string缓存
     * @param $key
     * @param $value
     * @return bool
     */
    public function set($key, $value)
    {
        return $this->redis->set($key, $value);
    }

    /**
     * 设置string缓存同时设置过期时间
     * @param $key
     * @param $value
     * @param int $expire 过期时间,默认1小时
     * @return mixed
     */
    public function setEx($key, $value, $expire = self::API_EXPIRE_TIME)
    {
        return $this->redis->setex($key, $expire, $value);
    }

    /**
     * 获取string类型缓存
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->redis->get($key);
    }

    /**
     * 清除此key值下的数据
     * @param $key
     * @return bool
     */
    public function del($key)
    {
        return $this->redis->del($key);
    }

    /**
     * 匹配批量删除此key下所有的值,谨慎使用
     * @param $pattern
     */
    public function delByPattern($pattern)
    {
        //获取所有key
        $keys = $this->redis->executeCommand('KEYS', [$pattern . '*']);
        //循环删除
        foreach ($keys as $key) {
            $this->del($key);
        }
    }

    /**
     * 给key设置过期时间
     * @param $key
     * @param $expire
     * @return array|bool|null|string
     */
    public function expireAt($key, $expire)
    {
        return $this->redis->executeCommand('expire',[$key, $expire]);
    }

    /*
    * 判断key是否存在
    */
    public function exists($key)
    {
        return $this->redis->exists($key);
    }

    /**
     * 原子增加计数
     * @param $key
     * @param int $num
     * @return array|bool|null|string
     */
    public function incrBy($key, $num = 1)
    {
        return $this->redis->executeCommand('INCRBY', [$key, $num]);
    }


    //-------------- 队列相关 ------------
    /**
     * 左入队列
     * @param $key
     * @param $data
     * @return mixed
     */
    public function lPush($key, $data)
    {
        return $this->redis->LPUSH($key, $data);
    }

    /**
     * 左出队列
     * @param $key
     * @return mixed
     */
    public function lPop($key)
    {
        return $this->redis->LPOP($key);
    }

    /**
     * 右入队列
     * @param $key
     * @param $value
     * @return mixed
     */
    public function rPush($key, $value)
    {
        return $this->redis->RPUSH($key, $value);
    }

    /**
     * 右出队列
     * @param $key
     * @return mixed
     */
    public function rPop($key)
    {
        return $this->redis->RPOP($key);
    }

    /**
     *  获取队列长度
     * @param string $key
     * @return int
     */
    public function lLen($key)
    {
        return $this->redis->LLEN($key);
    }

    /**
     * 返回列表 key 中指定区间内的元素，区间以偏移量 START 和 END 指定
     * @param string $key
     * @param int $start
     * @param int $stop 截止位置,注意此位置上的数据也会被返回回去
     * @return array
     */
    public function lRange($key, $start, $stop)
    {
        return $this->redis->executeCommand('LRANGE', [$key, $start, $stop]);
    }

    /**
     * 对一个列表进行修剪(trim)，就是说，让列表只保留指定区间内的元素，不在指定区间之内的元素都将被删除
     * @param string $key
     * @param int $start
     * @param int $stop 截止位置,注意此位置上的数据也会被返回回去
     * @return bool
     */
    public function lTrim($key, $start, $stop)
    {
        return $this->redis->executeCommand('LTRIM', [$key, $start, $stop]);
    }


    //-------------- 哈希相关 --------------
    /**
     * 设置hash,单个field
     * @param string $key
     * @param string $field  字段
     * @param string $value  值
     * @return bool
     */
    public function hSet($key, $field, $value) {
        return $this->redis->HSET($key, $field, $value);
    }

    /**
     * 获取hash的field值
     * @param $key
     * @param $field
     * @return string
     */
    public function hGet($key, $field)
    {
        return $this->redis->HGET($key, $field);
    }

    /**
     * 设置hash,批量field
     * Redis Hmset 命令用于同时将多个 field-value (字段-值)对设置到哈希表中。
     * 此命令会覆盖哈希表中已存在的字段。如果哈希表不存在，会创建一个空哈希表，并执行 HMSET 操作。
     * @param string $key 设置hash的key
     * @param array $values 键值对
     * @return bool
     */
    public function hmSet($key, $values)
    {
        //格式化需要set的hash信息,标准格式['test_key', 'field1', 'val1', 'field2', 'val2']
        $setArr = [$key];
        foreach ($values as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $setArr[] = $key;
            $setArr[] = $value;
        }

        return $this->redis->executeCommand('HMSET', $setArr);
    }

    /**
     * 设置hash,批量field
     * @param string $key 设置hash的key
     * @param array $values 键值对
     * @param int $expire 过期时间
     */
    public function hmSetEx($key, $values, $expire = self::API_EXPIRE_TIME)
    {
        $this->hmSet($key, $values);

        //设置有效期
        $this->expireAt($key, $expire);
    }

    /**
     * 为哈希表 key 中的域 field 的值加上增量 increment
     * @param     $key
     * @param     $field
     * @param int $increment
     * @return bool
     */
    public function hmIncrBy($key, $field, $increment = 1)
    {
        return $this->redis->executeCommand('HINCRBY', [$key, $field, $increment]);
    }

    /**
     * 根据field批量获取hash的值
     * @param $key
     * @param array $fields 字段
     * @return array 注意:返回是处理好的关联数组
     */
    public function hmGet($key, $fields)
    {
        array_unshift($fields, $key); //把key插入到字段的头部
        $data = $this->redis->executeCommand('HMGET', $fields);

        if (in_array(null, $data, true)) { //由于hmget方法即使field没有值也会返回,所以如果出现了null,直接返回空,in_array需要严格判断
            return [];
        }

        //第一个元素为key,去掉
        array_shift($fields);

        //将两个索引数组合并成一个关联数组
        return array_combine($fields, $data);
    }

    /**
     * 命令用于返回哈希表中，所有的字段和值。
     * 在返回值里，紧跟每个字段名(field name)之后是字段的值(value)，所以返回值的长度是哈希表大小的两倍
     * @param $key
     * @return array
     */
    public function hGetAll($key)
    {
        $data = $this->redis->executeCommand('HGETALL', [$key]);
        if (!$data) {
            return [];
        }

        $keys = $value = []; //初始化key和value
        foreach ($data as $k => $v) {
            if ($k % 2 == 0) { //key
                $keys[] = $v;
            } else {
                $value[] = $v;
            }
        }

        return array_combine($keys, $value);
    }

    /**
     * 判断key中的某个field是否存在,存在返回1,不存在返回0
     * @param $key
     * @param $field
     * @return bool
     */
    public function hExists($key, $field)
    {
        return $this->redis->executeCommand('HEXISTS', [$key, $field]);
    }

    /**
     * 删除hash可以中某个field
     * @param $key
     * @param $field
     * @return bool
     */
    public function hDel($key, $field)
    {
        return $this->redis->HDEL($key, $field);
    }

    /**
     * 获取哈希表中的所有域（field）
     * @param $key
     * @return array
     */
    public function hGetKeys($key)
    {
        return $this->redis->executeCommand('HKEYS', $key);
    }


    //------------------ 并发锁相关 ------------------
    /**
     * 检测锁,有锁返回true
     * @param $key
     * @return bool
     */
    public function checkLock($key)
    {
        $num = $this->incrBy($key);
        $this->expireAt($key, 90); //设置过期时间,防止锁一直不释放
        if ($num > 1) { //进程已被加锁
            $this->incrBy($key, -1);
            return true;
        }

        return false;
    }

    /**
     * 释放锁
     * @param $key
     */
    public function releaseLock($key)
    {
        $this->incrBy($key, -1);
    }

    /**
     * 脚本运行锁
     * @param $key
     * @return bool
     */
    public function scriptLockCheck($key)
    {
        $num = $this->incrBy($key);
        if ($num > 1) { //进程已被加锁
            $this->incrBy($key, -1);
            return true;
        }

        return false;
    }

    /**
     * 脚本锁释放
     * @param $key
     * @return bool
     */
    public function scriptLockRelease($key)
    {
        return $this->del($key);
    }

    public function hlen($key)
    {
        return $this->redis->HLEN($key);
    }

    public function sadd($key, $value)
    {
        return $this->redis->sadd($key, $value);
    }

    public function scard($key)
    {
        return $this->redis->scard($key);
    }
}
