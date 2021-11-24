<?php
namespace frontend\dao;

use common\models\Wealth;

class WealthDao extends BaseDao
{
    public function SearchWealth($condition){
        $wealth = Wealth::find()->andWhere($condition)->asArray()->all();
        if(!$wealth) $wealth = new Wealth();
        return $wealth;
    }

    //修改居住地
    public function DeleteWealth($condition)
    {
        $info = Wealth::deleteAll($condition);

        if (!empty($info->errors))
            return ['status'=>500, 'Customer_id' => 0, 'message' => '更新信息失败'];

        return ['status' => 200, 'Customer_id' => $info->Customer_id, 'message' => ''];
    }

    //插入居住地
    public function InsertWealth($condition, $data)
    {
        foreach ($data as $ws){
            $wealth = new Wealth();
            foreach ($ws as $k=>$v){
                if (!empty($v))
                    $wealth->setAttribute($k, $v);
            }
            $wealth->Customer_id = $condition['Customer_id'];
            $wealth->save(false);
        }

        if (!empty($wealth->errors))
            return ['status'=>500, 'Customer_id' => 0, 'message' => '更新信息失败'];

        return ['status' => 200, 'Customer_id' => $wealth->Customer_id, 'message' => ''];
    }
}