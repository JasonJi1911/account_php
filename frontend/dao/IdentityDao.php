<?php

namespace frontend\dao;

use common\models\Identity;

class IdentityDao extends BaseDao
{
    public function SearchIdentity($condition)
    {
        return Identity::findOne($condition);
    }

    public function UpdateIdentity($condition, $data)
    {
        $info = Identity::findOne($condition);
        $identity = new Identity();
        $identity->oldAttributes = $info;
        $identity->updateAttributes($data);
    }

    public function InsertIdentity($data)
    {
        $identity = new Identity();
        $identity::findOne(['Customer_id' => 0]);
//        $candidate->attributes = $data;
        foreach ($data as $k=>$v)
        {
            if (!empty($v))
                $identity->setAttribute($k, $v);
        }
        $identity->save(false);

        if (!empty($identity->errors))
            return ['status'=>500, 'Customer_id' => 0, 'message' => '创建身份信息失败'];

        return ['status' => 200, 'Customer_id' => $identity->Customer_id, 'message' => ''];
    }
}