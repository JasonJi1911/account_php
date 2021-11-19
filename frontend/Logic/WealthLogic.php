<?php
namespace frontend\Logic;

use common\models\Wealth;
use frontend\dao\WealthDao;

class WealthLogic
{
    //保存居住地
    public function SaveWealth($condition, $data)
    {
        $wealthDao = new WealthDao();

        $result = $wealthDao->DeleteWealth($condition);
        if($result['status']==200){
            $result = $wealthDao->InsertWealth($condition, $data);
        }
        return $result;
    }
}