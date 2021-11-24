<?php

namespace frontend\dao;

use common\models\Financial;
use common\models\info\Account;

class InfoDao extends BaseDao
{

    public function SearchFinancial($condition)
    {
        return Financial::findOne($condition);
    }

    //修改Financial
    public function UpdateFinancial($condition, $data)
    {
        $info = Financial::findOne($condition);
        $financial = new Financial();
        $financial->oldAttributes = $info;
        $financial->updateAttributes($data);

        if (!empty($financial->errors))
            return ['status'=>500, 'Customer_id' => 0, 'message' => '更新信息失败'];

        return ['status' => 200, 'Customer_id' => $financial->Customer_id, 'message' => ''];
    }

    //插入Financial
    public function InsertFinancial($condition, $data)
    {
        $financial = new Financial();
        foreach ($data as $k=>$v){
            if (!empty($v))
                $financial->setAttribute($k, $v);
        }
        $financial->Customer_id = $condition['Customer_id'];
        $financial->save(false);

        if (!empty($financial->errors))
            return ['status'=>500, 'Customer_id' => 0, 'message' => '更新信息失败'];

        return ['status' => 200, 'Customer_id' => $financial->Customer_id, 'message' => ''];
    }


    public function SearchAccount($condition)
    {
        return Account::findOne($condition);
    }

    //修改Account
    public function UpdateAccount($condition, $data)
    {
        $info = Account::findOne($condition);
        $account = new Account();
        $account->oldAttributes = $info;
        $account->updateAttributes($data);

        if (!empty($account->errors))
            return ['status'=>500, 'Customer_id' => 0, 'message' => '更新信息失败'];

        return ['status' => 200, 'Customer_id' => $account->Customer_id, 'message' => ''];
    }

    //插入Account
    public function InsertAccount($condition, $data)
    {
        $account = new Account();
        foreach ($data as $k=>$v){
            if (!empty($v))
                $account->setAttribute($k, $v);
        }
        $account->Customer_id = $condition['Customer_id'];
        $account->save(false);

        if (!empty($account->errors))
            return ['status'=>500, 'Customer_id' => 0, 'message' => '更新信息失败'];

        return ['status' => 200, 'Customer_id' => $account->Customer_id, 'message' => ''];
    }
}