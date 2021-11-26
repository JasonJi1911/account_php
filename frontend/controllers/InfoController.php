<?php
namespace frontend\controllers;

use common\models\Candidate;
use common\models\Country;
use common\models\Dict;
use common\models\Employment;
use common\models\EmployerBusiness;
use common\models\Financial;
use common\models\FinancialRange;
use common\models\info\Account;
use common\models\Investment;
use common\models\Phone;
use common\models\Resident;
use common\models\Tax;
use common\models\Wealth;
use frontend\Logic\CandidateLogic;
use frontend\Logic\EmploymentLogic;
use frontend\Logic\InfoLogic;
use frontend\Logic\InvestmentLogic;
use frontend\Logic\ResidentLogic;
use frontend\Logic\TaxLogic;
use frontend\Logic\WealthLogic;
use frontend\models\UploadForm;
use yii\web\UploadedFile;
use Yii;
use yii\helpers\Url;

class InfoController extends BaseController
{
    /*
     * 联系信息
     */
    public function actionContactinfo(){
        $customer_id = Yii::$app->request->get('Customer_id', '');

        $data = [];
        $candidate = Candidate::findOne(['Customer_id' => $customer_id]);
        if (!$candidate)
            $candidate = new Candidate();

        $resident = Resident::findOne(['Customer_id' => $customer_id]);
        if (!$resident){
            $resident = new Resident();
        }else{
            $country = Country::findOne(['state_code'=>$resident['state'],'city_en'=>$resident['city']]);
            if($country){
                $data['city_cn'] = $country['city_cn'];
                $data['state_cn'] = $country['state_cn'];
            }else{
                $data['city_cn'] = '';
                $data['state_cn'] = '';
            }
        }

        $phone = Phone::findOne(['Customer_id' => $customer_id]);
        if (!$phone){
            $data['phone'] = '';
        }else{
            $data['phone'] = $phone['number'];
        }

        $state = Country::find()->select('state_en,state_cn,state_code')
                ->groupBy('state_en,state_cn,state_code')->asArray()->all();
        if(!$state) $state = [];

        $city = Country::find()->select('state_code,city_en,city_cn')->asArray()->all();
        if(!$city) $city = [];

        $candidateLogic = new CandidateLogic();
        if (Yii::$app->request->isPost) {
            $reponse = Yii::$app->request->post();
            $reponse_candidate = $reponse[Candidate::className()];
            $reponse_resident = $reponse[Resident::className()];
            $condition = ['Customer_id' => $customer_id];

            $candidateLogic->UpdateCandidate($condition, $reponse_candidate);
//
            $redisentLogic = new ResidentLogic();
            $country_code = Country::findOne(['state_code'=>$reponse_resident['state'],'city_en'=>$reponse_resident['city']]);
            $reponse_resident['country'] = $country_code['country_code'];
            $redisentLogic->SaveResident($condition,$reponse_resident);
            return $this->redirect(Url::to(['info/personinfo', 'Customer_id'=> $customer_id]));
        }
        else{
            $result = $this->ValidateCustomer($customer_id);
            if(!$result)
                return $this->redirect(Url::to(['/site/error']));
            $step = ['step' => TAB_CONTACTINFO];
            $candidateLogic->UpdateStep($customer_id, $step);
        }

        return $this->render('contactinfo', [
            'Customer_id'=> $customer_id,
            'candidate'  => $candidate,
            'resident'   => $resident,
            'data'       => $data,
            'state'      => json_encode($state),
            'city'       => json_encode($city)
        ]);
    }

    /*
     * 个人信息
     */
    public function actionPersoninfo(){
        $customer_id = Yii::$app->request->get('Customer_id', '');
        $data = [];
        $candidate = Candidate::findOne(['Customer_id' => $customer_id]);
        if (!$candidate){
            $candidate = new Candidate();
        }else{
            $msone = Dict::findOne(['type'=>'maritalStatus','dkey'=>$candidate['maritalStatus']]);
            if($msone){
                $data['maritalStatusName'] = $msone['dvalue'].'-'.$msone['dkey'];
            }else{
                $data['maritalStatusName'] = '';
            }
        }

        $tax = Tax::findOne(['Customer_id' => $customer_id]);
        if (!$tax)
            $tax = new Tax();

        $maritalStatus = Dict::find()->select('dkey,dvalue')
            ->andWhere(['type'=>'maritalStatus'])
            ->asArray()->all();
        if(!$maritalStatus) {
            $maritalStatus = [];
        }else{
            foreach($maritalStatus as &$m){
                $m['dvalue'] = $m['dvalue'].'-'.$m['dkey'];
            }
        }

        $candidateLogic = new CandidateLogic();
        if (Yii::$app->request->isPost) {
            $reponse = Yii::$app->request->post();
            $reponse_candidate = $reponse[Candidate::className()];
            $reponse_tax = $reponse[Tax::className()];
            $condition = ['Customer_id' => $customer_id];

            $candidateLogic->UpdateCandidate($condition, $reponse_candidate);

            $taxLogic = new TaxLogic();
            $taxLogic->SaveTax($condition,$reponse_tax);
            return $this->redirect(Url::to(['info/employinfo', 'Customer_id'=> $customer_id]));
        }
        else{
            $result = $this->ValidateCustomer($customer_id);
            if(!$result)
                return $this->redirect(Url::to(['/site/error']));
            $step = ['step' => TAB_PERSONINFO];
            $candidateLogic->UpdateStep($customer_id, $step);
        }

        return $this->render('personinfo', [
            'candidate'     => $candidate,
            'tax'           => $tax,
            'Customer_id'   => $customer_id,
            'maritalStatus' => json_encode($maritalStatus),
            'data'          => $data,
        ]);
    }

    /*
     * 雇佣信息
     */
    public function actionEmployinfo(){
        $customer_id = Yii::$app->request->get('Customer_id', '');
        $data = [];

        $candidate = Candidate::findOne(['Customer_id' => $customer_id]);
        if (!$candidate){
            $candidate = new Candidate();
        }else{
            $dict_rel = Dict::findOne(['type'=>'employStatus','dkey'=>$candidate['employment_type']]);
            $data['employStatus'] = $dict_rel['dvalue'];
        }

        $employment = Employment::findOne(['Customer_id'=>$customer_id]);
        if(!$employment){
            $employment = new Employment();
        }else{
            $country = Country::findOne(['state_code'=>$employment['state'],'city_en'=>$employment['city']]);
            if($country){
                $data['city_cn'] = $country['city_cn'];
                $data['state_cn'] = $country['state_cn'];
            }else{
                $data['city_cn'] = '';
                $data['state_cn'] = '';
            }
            $affliation_company_country = Country::findOne(['state_code'=>$employment['affliation_company_state'],'city_en'=>$employment['affliation_company_city']]);
            if($country){
                $data['aff_city_cn'] = $affliation_company_country['city_cn'];
                $data['aff_state_cn'] = $affliation_company_country['state_cn'];
            }else{
                $data['aff_city_cn'] = '';
                $data['aff_state_cn'] = '';
            }
            $embs_one = EmployerBusiness::findOne(['name'=>$employment['employer_business'],'occupation'=>$employment['occupation']]);
            if($embs_one){
                $data['employer_business'] = $embs_one['text'];
                $data['occupation'] = $embs_one['occupation_cn'];
            }else{
                $data['employer_business'] = $employment['employer_business'];
                $data['occupation'] = $employment['occupation'];
            }
            $dict_rel = Dict::findOne(['type'=>'affliation_relationship','dkey'=>$employment['affliation_relationship']]);
            $data['rel'] = $dict_rel['dvalue'];
        }

        //所有就业状态
        $employStatus = Dict::find()->select('dkey value, dvalue name')
                        ->andWhere(['type'=>'employStatus'])
                        ->asArray()->all();
        if(!$employStatus)  $employStatus = [];
        //所有州
        $state = Country::find()->select('state_en value,state_cn name,state_code id')
            ->groupBy('state_en,state_cn,state_code')->asArray()->all();
        if(!$state) $state = [];
        //所有城市
        $city = Country::find()->select('state_code id,city_en value,city_cn name')->asArray()->all();
        if(!$city) $city = [];
        //所有商业性质
        $em_bs = EmployerBusiness::find()->select('name value,text name')
            ->groupBy('name,text')->asArray()->all();
        if(!$em_bs) $em_bs = [];
        //所有职业
        $em_oc = EmployerBusiness::find()->select('name id,occupation value,occupation_cn name')->asArray()->all();
        if(!$em_oc) $em_oc = [];
        //所有亲属关系
        $rel = Dict::find()->select('dkey value,dvalue name')
            ->andWhere(['type'=>'affliation_relationship'])
            ->asArray()->all();

        $candidateLogic = new CandidateLogic();
        if (Yii::$app->request->isPost) {
            $reponse = Yii::$app->request->post();
            $reponse_candidate = $reponse[Candidate::className()];
            $reponse_employment = $reponse[Employment::className()];
            if($reponse_candidate['employment_type']!='EMPLOYED'){
                $reponse_employment['country'] = '';
                $reponse_employment['affliation_company_country'] = '';
            }else if($reponse_candidate['employment_type']=='EMPLOYED' && $reponse_employment['affiliation']==0){
                $reponse_employment['affliation_company_country'] = '';
            }
            $condition = ['Customer_id' => $customer_id];

            $candidateLogic->UpdateCandidate($condition, $reponse_candidate);

            $employmentLogic = new EmploymentLogic();
            $employmentLogic->SaveEmployment($condition, $reponse_employment);
            return $this->redirect(Url::to(['info/wealthsource', 'Customer_id'=> $customer_id]));
        }
        else{
            $result = $this->ValidateCustomer($customer_id);
            if(!$result)
                return $this->redirect(Url::to(['/site/error']));
            $step = ['step' => TAB_EMPLOYINFO];
            $candidateLogic->UpdateStep($customer_id, $step);
        }

        return $this->render('employinfo', [
            'Customer_id' => $customer_id,
            'candidate' => $candidate,
            'employment' => $employment,
            'employStatus' => json_encode($employStatus),
            'state' => json_encode($state),
            'city' => json_encode($city),
            'embs' => json_encode($em_bs),
            'emoc' => json_encode($em_oc),
            'rel' => json_encode($rel),
            'data' => $data,
        ]);
    }

    /*
     * 财富来源
     */
    public function actionWealthsource(){
        $customer_id = Yii::$app->request->get('Customer_id', '');
        $data = [];
        $wealthmodel = Wealth::find()->select('source_type id,percentage percent, description')
                    ->andWhere(['Customer_id'=>$customer_id])
                    ->asArray()->all();
        if(!$wealthmodel){
            $wealthmodel = [];
        }

        $ws = Dict::find()->select('dkey id, dvalue name')
            ->andWhere(['type'=>'wealthsource'])
            ->asArray()->all();
        if(!$ws){
            $ws = [];
        }else{
            foreach ($ws as $k=>&$w){
                $w['percent'] = '10';
                if($wealthmodel){
                    foreach ($wealthmodel as &$w2){
                        if(isset($w2['id']) && $w['id'] == $w2['id']){
                            $w2['name'] = $w['name'];
                            unset($ws[$k]);
                        }
                    }
                }
            }
        }
        $ws = array_values($ws);
        $wealthmodel = array_values($wealthmodel);

        if (Yii::$app->request->isPost) {
            $reponse = Yii::$app->request->post();
            $condition = ['Customer_id' => $customer_id];
            $param = [];
            foreach ($reponse as $k=>$v){
                $wsone = Dict::findOne(['type'=>'wealthsource','dkey'=>$k]);
                if (!empty($v) && $wsone){
                    $wealth = new Wealth();
                    $wealth['percentage'] = $v;
                    $wealth['source_type'] = $wsone['dkey'];
                    if($k=='SOW-IND-Other'){
                        $wealth['description'] = $reponse['othertext'];
                    }
                    $param[] = $wealth;
                }
            }

            $wealthLogic = new WealthLogic();
            $wealthLogic->SaveWealth($condition, $param);
            return $this->redirect(Url::to(['info/incomeasset', 'Customer_id'=> $customer_id]));
        }
        else{
            $result = $this->ValidateCustomer($customer_id);
            if(!$result)
                return $this->redirect(Url::to(['/site/error']));
            $step = ['step' => TAB_WEALTHSOURCE];
            $candidateLogic = new CandidateLogic();
            $candidateLogic->UpdateStep($customer_id, $step);
        }

        return $this->render('wealthsource', [
            'Customer_id' => $customer_id,
            'wealthsource' => json_encode($ws),
            'wealthmodel' => json_encode($wealthmodel),
            'data' => $data,
        ]);
    }

    /*
     * 收入和资产总值
     */
    public function actionIncomeasset(){
        $customer_id = Yii::$app->request->get('Customer_id', '');
        $data = [];

        $financial = Financial::findOne(['Customer_id'=>$customer_id]);
        if(!$financial) $financial = new Financial();

        //净收入
        $annual_net_income = [];
        //净资产
        $net_worth = [];
        //净流动资产
        $liquid_net_worth = [];
        $financialRange = FinancialRange::find()->andWhere(['currency'=>'AUD'])->asArray()->all();

        if($financialRange){
            foreach ($financialRange as $k=>$fr){
                $fdata = [];
                $fdata['value'] = $fr['range_id'];
                if($fr['lower_bound']==null || $fr['lower_bound']=='' || $fr['lower_bound']==0){
                    $fdata['name'] = '<'.$fr['upper_bound'];
                }else if($fr['upper_bound']==null || $fr['upper_bound']=='' || $fr['upper_bound']==0){
                    $fdata['name'] = '>'.$fr['lower_bound'];
                }else{
                    $fdata['name'] = $fr['lower_bound']."-".$fr['upper_bound'];
                }
                if($fr['criteria'] == 'annual_net_income'){
                    $annual_net_income[] = $fdata;
                    if($financial['annual_net_income'] == $fr['range_id']){
                        $data['annual_net_income'] = $fdata['name'];
                    }
                }else if($fr['criteria'] == 'net_worth'){
                    $net_worth[] = $fdata;
                    if($financial['net_worth'] == $fr['range_id']){
                        $data['net_worth'] = $fdata['name'];
                    }
                }else if($fr['criteria'] == 'liquid_net_worth'){
                    $liquid_net_worth[] = $fdata;
                    if($financial['liquid_net_worth'] == $fr['range_id']){
                        $data['liquid_net_worth'] = $fdata['name'];
                    }
                }
            }
        }

        if (Yii::$app->request->isPost) {
            $reponse = Yii::$app->request->post();
            $condition = ['Customer_id' => $customer_id];
            $reponse_financial = $reponse[Financial::className()];

            $infoLogic = new InfoLogic();
            $infoLogic->SaveFinancial($condition, $reponse_financial);
            return $this->redirect(Url::to(['info/uploadproof', 'Customer_id'=> $customer_id]));
        }
        else{
            $result = $this->ValidateCustomer($customer_id);
            if(!$result)
                return $this->redirect(Url::to(['/site/error']));
            $step = ['step' => TAB_INCOMEASSET];
            $candidateLogic = new CandidateLogic();
            $candidateLogic->UpdateStep($customer_id, $step);
        }

        return $this->render('incomeasset', [
            'Customer_id' => $customer_id,
            'financial'=>$financial,
            'annual_net_income' => json_encode($annual_net_income),
            'net_worth' => json_encode($net_worth),
            'liquid_net_worth' => json_encode($liquid_net_worth),
            'data' => $data,
        ]);
    }

    /*
     * 证明上传
     */
    public function actionUploadproof(){
        $customer_id = Yii::$app->request->get('Customer_id', '');
        $data = [];

        $financial = Financial::findOne(['Customer_id'=>$customer_id]);
        if(!$financial) $financial = new Financial();
        $financial->imageFile = $financial->picture;

        if (Yii::$app->request->isPost) {
            $financial->imageFile = UploadedFile::getInstance($financial, 'imageFile');
            if($financial->imageFile){
                if ($financial->upload()) {
                    // 文件上传成功，插入图片链接
                    $financial->picture = 'income/' . md5($financial->imageFile->baseName.$customer_id) . '.' . $financial->imageFile->extension;
                    $financial->Customer_id = $customer_id;
                    $financial->save(false);
                    return $this->redirect(Url::to(['info/accountinfo', 'Customer_id'=> $customer_id]));
                }
            }else if($financial['picture']!=''){
                return $this->redirect(Url::to(['info/accountinfo', 'Customer_id'=> $customer_id]));
            }else{
                $data['error'] = '请上传图片文件证明';
            }
        }
        else{
            $result = $this->ValidateCustomer($customer_id);
            if(!$result)
                return $this->redirect(Url::to(['/site/error']));
            $step = ['step' => TAB_UPLOADPROOF];
            $candidateLogic = new CandidateLogic();
            $candidateLogic->UpdateStep($customer_id, $step);
        }

        return $this->render('uploadproof', [
            'Customer_id' => $customer_id,
            'financial'=>$financial,
            'data'=>$data,
        ]);
    }

    /*
     * 账户信息
     */
    public function actionAccountinfo(){
        $customer_id = Yii::$app->request->get('Customer_id', '');
        $data = [];

        $account = Account::findOne(['Customer_id'=>$customer_id]);
        if(!$account) $account = new Account();

        $accountType = Dict::find()->select('dkey value, dvalue name')
            ->andWhere(['type'=>'AccountType'])
            ->asArray()->all();
        if(!$accountType){
            $accountType = [];
        }else{
//            $data['AccountType'] = $accountType[0]['name'];
            foreach ($accountType as $a) {
                if($a['value'] == $account['AccountType']){
                    $data['AccountType'] = $a['name'];
                }
            }
        }

        $base_currency = Dict::find()->select('dkey value, dvalue name')
            ->andWhere(['type'=>'base_currency'])
            ->asArray()->all();
        if(!$base_currency){
            $base_currency = [];
        }else{
//            $data['base_currency'] = $base_currency[0]['name'];
            foreach ($base_currency as $a) {
                if($a['value'] == $account['base_currency']){
                    $data['base_currency'] = $a['name'];
                }
            }
        }

        if (Yii::$app->request->isPost) {
            $reponse = Yii::$app->request->post();
            $condition = ['Customer_id' => $customer_id];
            $reponse_account = $reponse[Account::className()];

            $infoLogic = new InfoLogic();
            $infoLogic->SaveAccount($condition, $reponse_account);
            return $this->redirect(Url::to(['info/objective', 'Customer_id'=> $customer_id]));
        }
        else{
            $result = $this->ValidateCustomer($customer_id);
            if(!$result)
                return $this->redirect(Url::to(['/site/error']));
            $step = ['step' => TAB_ACCOUNTINFO];
            $candidateLogic = new CandidateLogic();
            $candidateLogic->UpdateStep($customer_id, $step);
        }

        return $this->render('accountinfo', [
            'Customer_id' => $customer_id,
            'account'=>$account,
            'accountType' => json_encode($accountType),
            'base_currency' => json_encode($base_currency),
            'data' => $data,
        ]);
    }

    /*
     * 投资目标
     */
    public function actionObjective(){
        $customer_id = Yii::$app->request->get('Customer_id', '');
        $data = [];

        $account = Account::findOne(['Customer_id'=>$customer_id]);
        if(!$account) $account = new Account();

        $investObj = Dict::find()->select('dkey value, dvalue name')
            ->andWhere(['type'=>'InvestmentObjectives'])
            ->asArray()->all();
        if(!$investObj){
            $investObj = [];
        }else{
            foreach ($investObj as &$obj){
                if($obj['value']=='Growth' || $obj['value']=='Trading' || $obj['value']=='Speculation'){
                    $obj['checked'] = true;
                }else{
                    $obj['checked'] = false;
                }
//                $obj['checked'] = false;
//                if($account['InvestmentObjectives']) {
//                    foreach (explode('+',$account['InvestmentObjectives']) as $v){
//                        if($obj['value'] == $v){
//                            $obj['checked'] = true;
//                        }
//                    }
//                }
            }
        }

        if (Yii::$app->request->isPost) {
            $reponse = Yii::$app->request->post();
            $condition = ['Customer_id' => $customer_id];
            $reponse_account = $reponse[Account::className()];
//
            $infoLogic = new InfoLogic();
            $infoLogic->SaveAccount($condition, $reponse_account);
            return $this->redirect(Url::to(['info/experience', 'Customer_id'=> $customer_id]));
        }
        else{
            $result = $this->ValidateCustomer($customer_id);
            if(!$result)
                return $this->redirect(Url::to(['/site/error']));
            $step = ['step' => TAB_OBJECTIVE];
            $candidateLogic = new CandidateLogic();
            $candidateLogic->UpdateStep($customer_id, $step);
        }

        return $this->render('objective', [
            'Customer_id' => $customer_id,
            'account'=>$account,
            'investObj' => json_encode($investObj),
//            'data' => $data,
        ]);
    }

    /*
     * 投资经验
     */
    public function actionExperience(){
        $customer_id = Yii::$app->request->get('Customer_id', '');
        $data = [];

        $candidate = Candidate::findOne(['Customer_id' => $customer_id]);
        $data['DOB'] = (!$candidate) ? '' : $candidate['DOB'];

        $stk = Investment::findOne(['Customer_id' => $customer_id, 'asset_class'=>'STK']);
        if(!$stk){
            $data['STK'] = new Investment();
        }else{
            $data['STK'] = $stk;
        }
        $cash = Investment::findOne(['Customer_id' => $customer_id, 'asset_class'=>'CASH']);
        if(!$cash){
            $data['CASH'] = new Investment();
        }else{
            $data['CASH'] = $cash;
        }

        $data['stklevel'] = '';
        $data['cashlevel'] = '';
        $level = Dict::find()->select('dkey value, dvalue name')
            ->andWhere(['type'=>'knowledge_level'])
            ->asArray()->all();
        if(!$level){
            $level = [];
        }else{
            foreach ($level as $l){
                if($l['value'] == $data['CASH']['knowledge_level']){
                    $data['cashlevel'] = $l['name'];
                }
                if($l['value'] == $data['STK']['knowledge_level']){
                    $data['stklevel'] = $l['name'];
                }
            }
        }

        if (Yii::$app->request->isPost) {
            $reponse = Yii::$app->request->post();
            $condition = ['Customer_id' => $customer_id];
            $reponse_account = [];
            if($reponse['asset_class0'] == '是'){
                $invest0 = new Investment();
                $invest0->asset_class = 'STK';
                $invest0->years_trading = $reponse['year0'];
                $invest0->trades_per_year = $reponse['trades0'];
                $invest0->knowledge_level = $reponse['level0'];
                $reponse_account[] = $invest0;
             }
            if($reponse['asset_class1'] == '是'){
                $invest1 = new Investment();
                $invest1->asset_class = 'CASH';
                $invest1->years_trading = $reponse['year1'];
                $invest1->trades_per_year = $reponse['trades1'];
                $invest1->knowledge_level = $reponse['level1'];
                $reponse_account[] = $invest1;
            }

            $investmentLogic = new InvestmentLogic();
            $investmentLogic->SaveInvestment($condition, $reponse_account);
            return $this->redirect(Url::to(['account/regulatory', 'Customer_id'=> $customer_id]));
        }
        else{
            $result = $this->ValidateCustomer($customer_id);
            if(!$result)
                return $this->redirect(Url::to(['/site/error']));
            $step = ['step' => TAB_EXPERIENCE];
            $candidateLogic = new CandidateLogic();
            $candidateLogic->UpdateStep($customer_id, $step);
        }

        return $this->render('experience', [
            'Customer_id' => $customer_id,
            'level' => json_encode($level),
            'data' => $data,
        ]);
    }

    private function ValidateCustomer($customer_id)
    {
        if(!$customer_id)
            return false;

        $candidateLogic = new CandidateLogic();
        $candidate = $candidateLogic->GetCandidate($customer_id);
        if(!$candidate)
            return false;

        return true;
    }

    public function actionSuccess(){
        $customer_id = Yii::$app->request->get('Customer_id', '');
        $accountType = Yii::$app->request->get('accountType', '');
        $account = Yii::$app->request->get('account', '');
        $data = [];
        $candidate = Candidate::findOne(['Customer_id' => $customer_id]);
        if (!$candidate)
            $candidate = new Candidate();

        $data['name'] = $candidate['last_name'] .' '. $candidate['first_name'];
        $data['accountType'] = $accountType;
        $data['account'] = $account;

        return $this->render('success', [
            'Customer_id' => $customer_id,
            'data' => $data,
        ]);
    }
}