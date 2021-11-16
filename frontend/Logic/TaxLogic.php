<?php
namespace frontend\Logic;


use common\models\Tax;
use frontend\dao\TaxDao;

class TaxLogic
{
    //保存居住地
    public function SaveTax($condition, $data)
    {
        $taxDao = new TaxDao();
        $info = Tax::findOne($condition);
        if($info){
            $result = $taxDao->UpdateTax($condition, $data);
        }else{
            $result = $taxDao->InsertTax($condition, $data);
        }
        return $result;
    }
}