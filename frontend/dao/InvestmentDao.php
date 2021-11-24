<?php
namespace frontend\dao;

use common\models\Investment;

class InvestmentDao extends BaseDao
{
    public function SearchInvestment($condition){
        return Investment::findOne($condition);
    }

    //修改
    public function DeleteInvestment($condition)
    {
        $info = Investment::deleteAll($condition);

        if (!empty($info->errors))
            return ['status'=>500, 'Customer_id' => 0, 'message' => '更新信息失败'];

        return ['status' => 200, 'Customer_id' => $info->Customer_id, 'message' => ''];
    }

    //插入
    public function InsertInvestment($condition, $data)
    {
        foreach ($data as $ws){
            $investment = new Investment();
            foreach ($ws as $k=>$v){
                if (!empty($v))
                    $investment->setAttribute($k, $v);
            }
            $investment->Customer_id = $condition['Customer_id'];
            $investment->save(false);
        }

        if (!empty($investment->errors))
            return ['status'=>500, 'Customer_id' => 0, 'message' => '更新信息失败'];

        return ['status' => 200, 'Customer_id' => $investment->Customer_id, 'message' => ''];
    }
}