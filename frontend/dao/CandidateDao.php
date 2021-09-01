<?php

namespace frontend\dao;

use common\models\Candidate;

class CandidateDao extends BaseDao
{
    public function SearchCandidate($condition)
    {
        return Candidate::findOne($condition);
    }

    public function UpdateCandidate($condition, $data)
    {
        $info = Candidate::findOne($condition);
        $candidate = new Candidate();
        $info->oldAttributes = $info;
        $candidate->updateAttributes($data);
    }

    public function InsertCandidate($data)
    {
        $candidate = new Candidate();
        $candidate::findOne(['Customer_id' => 0]);
//        $candidate->attributes = $data;
        foreach ($data as $k=>$v)
            $candidate->setAttribute($k, $v);
        $candidate->save();

        if (!empty($candidate->errors))
            return ['status'=>500, 'Customer_id' => 0, 'message' => '创建新用户失败'];

        return ['status' => 200, 'Customer_id' => $candidate->Customer_id, 'message' => ''];
    }
}