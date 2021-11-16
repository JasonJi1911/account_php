<?php
namespace frontend\Logic;


use common\models\Resident;
use frontend\dao\ResidentDao;

class ResidentLogic
{
    //保存居住地
    public function SaveResident($condition, $data)
    {
        $residentDao = new ResidentDao();
        $info = Resident::findOne($condition);
        if($info){
            $result = $residentDao->UpdateResident($condition, $data);
        }else{
            $result = $residentDao->InsertResident($condition, $data);
        }
        return $result;
    }
}