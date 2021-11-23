<?php
namespace frontend\Logic;

use common\models\Investment;
use frontend\dao\InvestmentDao;

class InvestmentLogic
{
    //保存
    public function SaveInvestment($condition, $data)
    {
        $investmentDao = new InvestmentDao();

        $result = $investmentDao->DeleteInvestment($condition);
        if($result['status']==200){
            $result = $investmentDao->InsertInvestment($condition, $data);
        }
        return $result;
    }
}