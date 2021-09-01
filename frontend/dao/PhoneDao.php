<?php

namespace frontend\dao;

use common\models\Phone;

class PhoneDao extends BaseDao
{
    public function SearchPhone($condition)
    {
        return Phone::findOne($condition);
    }

    public function UpdatePhone($condition, $data)
    {
        $info = Phone::findOne($condition);
        $Phone = new Phone();
        $info->oldAttributes = $info;
        $Phone->updateAttributes($data);
    }

    public function InsertPhone($data)
    {
        $phone = new Phone();
//        $candidate->attributes = $data;
        foreach ($data as $k=>$v)
            $phone->setAttribute($k, $v);
        $phone->save();

        if (!empty($candidate->errors))
            return ['status'=>500, 'Customer_id' => 0, 'message' => '存储手机号失败'];

        return ['status' => 200, 'Customer_id' => $phone->Customer_id, 'message' => ''];
    }
}