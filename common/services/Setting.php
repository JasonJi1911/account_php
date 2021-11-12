<?php
namespace common\services;

//use common\helpers\RedisKey;
//use common\helpers\RedisStore;
use Yii;
use yii\helpers\ArrayHelper;

class Setting
{
    // 开关
    const SWITCH_ON  = 1; // 开启
    const SWITCH_OFF = 2; // 关闭

    /**
     * 获取配置项的值
     * @param string $key 配置的键，格式是: 配置组名.配置项名
     * @param array $params 查询条件,例如查询阿里云key时,需要区分场景
     * @return bool|mixed
     */
    public function get($key, $params = [])
    {
        if (($pos = strrpos($key, '.')) !== false) { //如果有.则取配置组名
            $groupKey = substr($key, 0, $pos);
            $settingKey = substr($key, $pos + 1);
        } else {
            $groupKey = $key;
            $settingKey = '';
        }
        $data = $this->_getSetting($groupKey, $params);

        if ($settingKey) { //获取具体的配置项
            return ArrayHelper::getValue($data, $settingKey, null);
        }

        return $data;
    }

    /**
     * 获取配置,根据组名获取
     * @param $group
     * @param array $params 额外的参数,用于查询有多条配置的情况,默认为id=1
     * @return array
     */
    private function _getSetting($group, $params=[])
    {
//        $key = RedisKey::getSettingKey($group, $params);
//        $redis = new RedisStore();
//        $strSetting = $redis->get($key);
//
//        if ($strSetting && $settings = json_decode($strSetting, true)) { //redis已有数据
//            return $settings;
//        }

        //查询表
        $modelClass = 'common\models\setting\Setting' . ucfirst($group);
        //查询附带参数
        if (empty($params)) {
            $params = 1;
        }
        $modelData = call_user_func([$modelClass, 'findOne'], $params);

        $data = $modelData->toArray(); //转成数组
        unset($data['id']); //去掉多余的id

        //写入redis
//        $redis->set($key, json_encode($data, JSON_UNESCAPED_UNICODE));
        return $data;
    }
}
