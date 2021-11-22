<?php
namespace frontend\dao;

use common\models\Candidate;
use common\models\Resident;

class ResidentDao extends BaseDao
{
    public function SearchResident($condition)
    {
        return Resident::findOne($condition);
    }

    //修改居住地
    public function UpdateResident($condition, $data)
    {
        $info = Resident::findOne($condition);
        $resident = new Resident();
        $resident->oldAttributes = $info;
        $resident->updateAttributes($data);

        if (!empty($resident->errors))
            return ['status'=>500, 'Customer_id' => 0, 'message' => '更新信息失败'];

        return ['status' => 200, 'Customer_id' => $resident->Customer_id, 'message' => ''];
    }

    //插入居住地
    public function InsertResident($condition, $data)
    {
        $resident = new Resident();
        foreach ($data as $k=>$v){
            if (!empty($v))
                $resident->setAttribute($k, $v);
        }
        $resident->Customer_id = $condition['Customer_id'];
        $resident->save(false);

        if (!empty($resident->errors))
            return ['status'=>500, 'Customer_id' => 0, 'message' => '更新信息失败'];

        return ['status' => 200, 'Customer_id' => $resident->Customer_id, 'message' => ''];
    }
}