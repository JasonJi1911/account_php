<?php
namespace frontend\Logic;

use common\models\Employment;
use frontend\dao\EmploymentDao;

class EmploymentLogic
{
    //保存居住地
    public function SaveEmployment($condition, $data)
    {
        $employmentDao = new EmploymentDao();
        $info = Employment::findOne($condition);
        if($info){
            $result = $employmentDao->UpdateEmployment($condition, $data);
        }else{
            $result = $employmentDao->InsertEmployment($condition, $data);
        }
        return $result;
    }
}