<?php

namespace frontend\Logic;

use common\models\info\Account;
use frontend\dao\InfoDao;
use common\models\Financial;

class InfoLogic
{
    //保存Financial
    public function SaveFinancial($condition, $data)
    {
        $infoDao = new InfoDao();
        $info = Financial::findOne($condition);
        if($info){
            $result = $infoDao->UpdateFinancial($condition, $data);
        }else{
            $result = $infoDao->InsertFinancial($condition, $data);
        }
        return $result;
    }

    //保存Account
    public function SaveAccount($condition, $data)
    {
        $infoDao = new InfoDao();
        $info = Account::findOne($condition);
        if($info){
            $result = $infoDao->UpdateAccount($condition, $data);
        }else{
            $result = $infoDao->InsertAccount($condition, $data);
        }
        return $result;
    }
}