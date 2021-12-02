<?php

namespace frontend\Logic;

use common\models\Country;
use common\models\Dict;
use common\models\FinancialRange;
use common\models\info\Account;
use frontend\dao\InfoDao;
use common\models\Financial;

class InfoLogic
{
    /*
     * 查收入或资产
     */
    public function FindIncomeAndAsset($condition,$currency){
        $infodao = new InfoDao();
        $result = [];
        $financial = $infodao->SearchFinancial($condition);
        if(!$financial){
            return ;
        }
        $result['net_worth_value'] = $this->financialValue($financial['net_worth'],$currency,'net_worth');
        $result['liquid_net_worth_value'] = $this->financialValue($financial['liquid_net_worth'],$currency,'liquid_net_worth');
        $result['annual_net_income_value'] = $this->financialValue($financial['annual_net_income'],$currency,'annual_net_income');
        return $result;
    }
    /*
     * 返回收入 / 资产 范围值
     */
    private function financialValue($rangeid,$currency,$type){
        $result = '';
        $fr = FinancialRange::findOne(['currency'=>$currency,'criteria'=>$type, 'range_id'=>$rangeid]);
        if($rangeid==0){
            $result = '<'.$fr['upper_bound'];
        }else if($fr['upper_bound']==null || $fr['upper_bound']=='' || $fr['upper_bound']==0){
            $result = '>'.$fr['lower_bound'];
        }else{
            $result = $fr['lower_bound']."-".$fr['upper_bound'];
        }
        return $result;
    }

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

    //
    public function FindInvestmentObjectives($condition){
        $infodao = new InfoDao();
        $account = $infodao->SearchAccount($condition);
        if(!$account) return ;
        $str = '';
        foreach (explode('+',$account['InvestmentObjectives']) as $v){
            $investObj = Dict::findOne(['type'=>'InvestmentObjectives','dkey'=>$v]);
            if($investObj){
                if($str==''){
                    $str = $investObj['dvalue'];
                }else{
                    $str .= ', '. $investObj['dvalue'];
                }
            }
        }
        return $str;
    }

    /*
     * 州/省 排序
     */
    public function getState($param=[]){
        $state = Dict::find()->andWhere(['type'=>'state_order'])
                ->orderBy('dkey desc')
                ->asArray()->all();
        if(!$state){
            return ;
        }
        $param['state_en'] = isset($param['state_en'])?$param['state_en']:'state_en';
        $param['state_cn'] = isset($param['state_cn'])?$param['state_cn']:'state_cn';
        $param['state_code'] = isset($param['state_code'])?$param['state_code']:'state_code';
        foreach ($state as &$s){
            $country_state = Country::findOne(['state_code'=>$s['dvalue']]);
            $s[$param['state_en']] = $country_state['state_en'];
            $s[$param['state_cn']] = $country_state['state_cn'];
            $s[$param['state_code']] = $country_state['state_code'];
        }
        return $state;
    }

}