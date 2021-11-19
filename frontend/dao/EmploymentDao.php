<?php
namespace frontend\dao;

use common\models\Employment;

class EmploymentDao extends BaseDao
{
    //修改居住地
    public function UpdateEmployment($condition, $data)
    {
        $info = Employment::findOne($condition);
        $employment = new Employment();
        $employment->oldAttributes = $info;
        $employment->updateAttributes($data);

        if (!empty($employment->errors))
            return ['status'=>500, 'Customer_id' => 0, 'message' => '更新信息失败'];

        return ['status' => 200, 'Customer_id' => $employment->Customer_id, 'message' => ''];
    }

    //插入居住地
    public function InsertEmployment($condition, $data)
    {
        $employment = new Employment();
        foreach ($data as $k=>$v){
            if (!empty($v))
                $employment->setAttribute($k, $v);
        }
        $employment->Customer_id = $condition['Customer_id'];
        $employment->save(false);

        if (!empty($employment->errors))
            return ['status'=>500, 'Customer_id' => 0, 'message' => '更新信息失败'];

        return ['status' => 200, 'Customer_id' => $employment->Customer_id, 'message' => ''];
    }
}