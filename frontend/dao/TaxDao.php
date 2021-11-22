<?php
namespace frontend\dao;

use common\models\Tax;

class TaxDao extends BaseDao
{
    public function SearchTax($condition)
    {
        return Tax::findOne($condition);
    }

    //修改居住地
    public function UpdateTax($condition, $data)
    {
        $info = Tax::findOne($condition);
        $tax = new Tax();
        $tax->oldAttributes = $info;
        $tax->updateAttributes($data);

        if (!empty($tax->errors))
            return ['status'=>500, 'Customer_id' => 0, 'message' => '更新信息失败'];

        return ['status' => 200, 'Customer_id' => $tax->Customer_id, 'message' => ''];
    }

    //插入居住地
    public function InsertTax($condition, $data)
    {
        $tax = new Tax();
        foreach ($data as $k=>$v){
            if (!empty($v))
                $tax->setAttribute($k, $v);
        }
        $tax->Customer_id = $condition['Customer_id'];
        $tax->save(false);

        if (!empty($tax->errors))
            return ['status'=>500, 'Customer_id' => 0, 'message' => '更新信息失败'];

        return ['status' => 200, 'Customer_id' => $tax->Customer_id, 'message' => ''];
    }
}