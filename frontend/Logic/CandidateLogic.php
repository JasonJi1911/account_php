<?php

namespace frontend\Logic;

use common\models\Phone;
use frontend\dao\PhoneDao;
use frontend\dao\CandidateDao;

class CandidateLogic
{
    public function IsNewCandidate($phone)
    {
        $phoneDao = new PhoneDao();
        $phoneCondition = ['number' => $phone];
        $phoneInfo = $phoneDao->SearchPhone($phoneCondition);

        if (!$phoneInfo)
            return true;

        $candidateDao = new CandidateDao();
        $candiCondition = ['Customer_id' => $phoneInfo['Customer_id']];
        $candiInfo = $candidateDao->SearchCandidate($candiCondition);

        if (!$candiInfo)
            return true;

        return false;
    }

    public function Register($phoneData, $candiData)
    {
        if ($candiData)
        {
            $candidateDao = new CandidateDao();
            $CandiResult = $candidateDao->InsertCandidate($candiData);
        }

        if (!$CandiResult || $CandiResult['Customer_id'] == 0)
            return $CandiResult;

        if ($phoneData)
        {
            $phoneDao = new PhoneDao();
            $phoneData['Customer_id'] = $CandiResult['Customer_id'];
            $phoneResult = $phoneDao->InsertPhone($phoneData);
        }

        return $phoneResult;
    }

    public function UpdatePhone($condition, $data)
    {
        $phoneDao = new PhoneDao();
        $phoneDao->UpdatePhone($condition, $data);
    }

    public function RegisterNewCandidate($phoneData, $candiData)
    {
        if ($this->IsNewCandidate($phoneData['number']))
        {
            return $this->Register($phoneData, $candiData);
        }

        $phone = Phone::findOne(['number' => $phoneData['number']]);
        $condition = ['Customer_id' => $phone['Customer_id']];
        $this->UpdatePhone($condition, $phoneData);
        return ['status' => 200, 'Customer_id' => $phone['Customer_id'], 'message' => ''];
    }

    public function SwitchTag($customer_id)
    {
        $candidateDao = new CandidateDao();
        $canditda = $candidateDao->SearchCandidate(['Customer_id' => $customer_id]);

        $step = $canditda['step'];
        if (!isset($step))
            $step = 1;
        else{
            $step = $step == 10 ? $step : (++$step);
        }

        return $step;
    }

    public function UpdateStep($customer_id, $data)
    {
        $candidateDao = new CandidateDao();
        $condition = ['Customer_id' => $customer_id];
        $candidateDao->UpdateCandidate($condition, $data);
    }

    public function GetCandidate($customer_id)
    {
        $candidateDao = new CandidateDao();
        $info = $candidateDao->SearchCandidate(['Customer_id' => $customer_id]);
        return $info;
    }
}