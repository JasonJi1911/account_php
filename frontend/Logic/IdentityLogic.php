<?php

namespace frontend\Logic;

use common\models\Phone;
use frontend\dao\PhoneDao;
use frontend\dao\CandidateDao;
use frontend\dao\IdentityDao;

class IdentityLogic
{
    public function InsertNewIdentity($candiData, $ifValidate=false)
    {
        if ($candiData)
        {
            $identityDao = new IdentityDao();
            $result = $identityDao->InsertIdentity($candiData, $ifValidate);
        }

        if (!$result)
            return ['status'=>500, 'Customer_id' => 0, 'message' => '创建身份信息失败'];

        return $result;
    }
}