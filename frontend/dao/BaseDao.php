<?php
namespace frontend\dao;

use yii\base\Component;

class BaseDao extends Component
{
    /**
     * 批量强转int型,用于读redis hash数据格式发生变化
     * @param $data
     * @param $fields
     * @return mixed
     */
    public function batchInt($data, $fields)
    {
        foreach ($fields as $field) {
            $data[$field] = intval($data[$field]);
        }

        return $data;
    }

    /**
     * 根据传入字段来过滤值
     * @param array $array
     * @param array $fields
     * @return array
     */
    public function filter($array, $fields)
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
}
