<?php

namespace frontend\controllers;

use common\helpers\Tool;
use Yii;

class CalculatorController extends BaseController
{
    public function actionIndex(){
        $data = [];
        $data['name'] = Yii::$app->request->get('name', '');
        $data['price'] = Yii::$app->request->get('price', 0);
        $data['currency'] = Yii::$app->request->get('currency', '');

        return $this->render('index', [
            'data' => $data,
        ]);
    }

    public function actionSearch(){

        return $this->render('search');
    }

    public function actionStocks(){
        $symbol = Yii::$app->request->get('symbol', '');
        $url = "http://api.moneycatrading.com/index.php?app=ibkr&act=contract_secdef_search";
        $param['symbol'] = $symbol;
        $returnList = Tool::httpPost($url,$param);
//        $data = '';
        $result = [];
        if($returnList['http_code']==200){
            $data = json_decode($returnList['data'],true);

//                    $result[]['name'] = $data['data'][0]['chineseName'];
            if(isset($data['data'])){
//                $r = [];
                foreach ($data['data'] as $s){
                    $r['conid'] = $s['conid'];
                    if($s['display_name']!=''){
                        $r['name'] = $s['display_name'];
                    }else if($s['chineseName']!=''){
                        $r['name'] = $s['chineseName'];
                    }else{
                        $r['name'] = $s['name'];
                    }
                    $r['currency'] = $s['currency'];
                    if($s['currency']=='USD'){
                        $r['icon'] = 'img/US.png';
                    }else if($s['currency']=='HKD'){
                        $r['icon'] = 'img/HK.png';
                    }else{
                        $r['icon'] = 'img/ASX.png';
                    }
                    $r['price'] = $s['last_price'];
                    $r['code'] = $s['ticker'];
                    $result[] = $r;
                }
            }
        }//

        return Tool::responseJson(0,'????????????',$result);
    }

    public function actionDetail(){
        $data = [];
        $data['name'] = Yii::$app->request->get('name', '');
        $data['price'] = Yii::$app->request->get('price', 0);
        $data['num'] = Yii::$app->request->get('num', 0);
        $data['currency'] = Yii::$app->request->get('currency', '');

        $currencyList = ['USD'=>'??????','HKD'=>'??????','AUD'=>'??????'];
        $data['currencyname'] = $currencyList[$data['currency']];

        $commission = 0;//????????????
        $exchange = 0;//???????????????
        $settlement = 0;//????????????
        $liquidation = 0;//????????????
        $agentNYSE = 0;//NYSE?????????
        $agentFINRE = 0;//FINRA?????????
        $exchangeFINRE = 0;//FINRA???????????????
        $total = 0;//?????????
        if($data['currency']=='USD'){//??????
            //??????
            $USstep = [ 0.0035,     //??? 300,000???
                0.002,      //300,001 - 3,000,000???
                0.0015,     //3,000,001 - 20,000,000???
                0.001,      //20,000,001 - 100,000,000???
                0.0005,     //> 100,000,000???
            ];//??????????????????IB??????
            $USnum = [300000,3000000,20000000,100000000,0];//??????????????????????????????????????????>100000000
            $USpricelist = [
                0.00020,    //NSCC, DTC???
                0.000175,   //NYSE????????? = IB???????????????*0.000175
                0.00056,    //FINRA????????? = IB???????????????*0.00056
                0.000119    //FINRA??????????????? = 0.000119*????????????
            ];
            $commission = $data['num'] * 0.0036;//????????????
            if($commission<0.4){
                $commission = 0.4;
            }else if($commission > ($data['num'] * $data['price'] * 0.01)){
                $commission = $data['num'] * $data['price'] * 0.01;
            }
            $liquidation = $USpricelist[0];//????????????
            //IB????????????
            $stepPrice = 0;
            foreach ($USnum as $k=>$n){
                if(($n !=0 && $data['num'] < $n) || $n == 0){
                    if($k==0){
                        $stepPrice = $data['num'] * $USstep[$k];
                    }else{
                        $stepPrice = $USnum[0] * $USstep[0];
                        while ($k > 1) {
                            $stepPrice = $stepPrice + ($data['num'] - $USnum[$k-1]) * $USstep[$k];
                            $k--;
                        }
                    }
                    break;
                }
            }
            $agentNYSE = $stepPrice * $USpricelist[1];//NYSE?????????=IB???????????????*0.000175
            $agentFINRE = $stepPrice * $USpricelist[2];//FINRA????????? = IB???????????????*0.00056
            $exchangeFINRE = $data['num'] * $USpricelist[3];//FINRA???????????????=0.000119*????????????
            $total = $commission + $liquidation + $agentNYSE + $agentFINRE + $exchangeFINRE;
        }else if($data['currency']=='HKD'){//??????
            $HKpricelist = [
                0.0009,    //????????????0.09%
                0.00005,    //??????????????? 0.005% ?????????
                0.5,        //??????????????? +HKD 0.50 ????????????
                0.00002    //????????????0.002% ?????????
            ];
            $commission = $data['num'] * $data['price'] * $HKpricelist[0];//????????????
            $commission = $commission < 13 ? 13 : $commission;
            $exchange = $data['num'] * $data['price'] * $HKpricelist[1] + $HKpricelist[2];//???????????????
            $settlement = $data['num'] * $data['price'] * $HKpricelist[3] ;//????????????
            if($settlement<2){
                $settlement = 2;
            }else if($settlement>100){
                $settlement = 100;
            }
            $total = $commission + $exchange + $settlement;
        }else{//??????
            $AUpricelist = [
                0.0009,    //????????????0.09%
                0.0000165,    //??????????????? 0.00165% ???????????????
                0.00011695    //????????????0.011695% ???????????????
            ];
            $commission = $data['num'] * $data['price'] * $AUpricelist[0];//????????????
            $commission = $commission < 6 ? 6 : $commission;
            $exchange = $data['num'] * $data['price'] * $AUpricelist[1];//???????????????
            $settlement = $data['num'] * $data['price'] * $AUpricelist[2];//????????????
            $total = $commission + $exchange + $settlement;
        }
        $nn = 4;
        $data['commission'] = ($commission>0?round($commission,$nn):0);//????????????
        $data['exchange'] = ($exchange>0?round($exchange,$nn):0);//?????????????????????/??????
        $data['settlement'] = ($settlement>0?round($settlement,$nn):0);//??????????????????/??????
        $data['liquidation'] = ($liquidation>0?round($liquidation,$nn):0);//?????????????????????
        $data['agentNYSE'] = ($agentNYSE>0?round($agentNYSE,$nn):0);//NYSE??????????????????
        $data['agentFINRE'] = ($agentFINRE>0?round($agentFINRE,$nn):0);//FINRA??????????????????
        $data['exchangeFINRE'] = ($exchangeFINRE>0?round($exchangeFINRE,$nn):0);//FINRA????????????????????????
        $data['total'] = ($total>0?round($total,$nn):0);//?????????
        $total1 = $data['num'] * $data['price'] + $total;
        $data['total1'] = ($total1>0?round($total1,$nn):0);

        return $this->render('detail', [
            'data' => $data,
        ]);
    }
}