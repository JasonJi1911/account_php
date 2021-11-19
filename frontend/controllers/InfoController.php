<?php
namespace frontend\controllers;

use common\models\Candidate;
use common\models\Country;
use common\models\Dict;
use common\models\Employment;
use common\models\EmployerBusiness;
use common\models\Phone;
use common\models\Resident;
use common\models\Tax;
use frontend\Logic\CandidateLogic;
use frontend\Logic\EmploymentLogic;
use frontend\Logic\ResidentLogic;
use frontend\Logic\TaxLogic;
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
        if(!$state) $state = [''];

        $city = Country::find()->select('state_code,city_en,city_cn')->asArray()->all();
        if(!$city) $city = [''];

        if (Yii::$app->request->isPost) {
            $reponse = Yii::$app->request->post();
            $reponse_candidate = $reponse[Candidate::className()];
            $reponse_resident = $reponse[Resident::className()];
            $condition = ['Customer_id' => $customer_id];

            $candidateLogic = new CandidateLogic();
            $candidateLogic->UpdateCandidate($condition, $reponse_candidate);
//
            $redisentLogic = new ResidentLogic();
            $redisentLogic->SaveResident($condition,$reponse_resident);
            return $this->redirect(Url::to(['info/personinfo', 'Customer_id'=> $customer_id]));
        }
//        else{ 
//            $result = $this->ValidateCustomer($customer_id);
//            if(!$result)
//                return $this->redirect(Url::to(['/site/error']));
//            $data = ['step' => TAB_NATIONALITY];
//            $candidateLogic->UpdateStep($customer_id, $data);
//        }

        return $this->render('contactinfo', [
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
            $maritalStatus = [''];
        }else{
            foreach($maritalStatus as &$m){
                $m['dvalue'] = $m['dvalue'].'-'.$m['dkey'];
            }
        }

        if (Yii::$app->request->isPost) {
            $reponse = Yii::$app->request->post();
            $reponse_candidate = $reponse[Candidate::className()];
            $reponse_tax = $reponse[Tax::className()];
            $condition = ['Customer_id' => $customer_id];

            $candidateLogic = new CandidateLogic();
            $candidateLogic->UpdateCandidate($condition, $reponse_candidate);

            $taxLogic = new TaxLogic();
            $taxLogic->SaveTax($condition,$reponse_tax);
            return $this->redirect(Url::to(['info/employinfo', 'Customer_id'=> $customer_id]));
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
        $employStatus = Dict::find()->select('dvalue')
                        ->andWhere(['type'=>'employStatus'])
                        ->asArray()->all();
        if(!$employStatus)  $employStatus = [''];
        //所有州
        $state = Country::find()->select('state_en value,state_cn name,state_code id')
            ->groupBy('state_en,state_cn,state_code')->asArray()->all();
        if(!$state) $state = [''];
        //所有城市
        $city = Country::find()->select('state_code id,city_en value,city_cn name')->asArray()->all();
        if(!$city) $city = [''];
        //所有商业性质
        $em_bs = EmployerBusiness::find()->select('name value,text name')
            ->groupBy('name,text')->asArray()->all();
        if(!$em_bs) $em_bs = [''];
        //所有职业
        $em_oc = EmployerBusiness::find()->select('name id,occupation value,occupation_cn name')->asArray()->all();
        if(!$em_oc) $em_oc = [''];
        //所有亲属关系
        $rel = Dict::find()->select('dkey value,dvalue name')
            ->andWhere(['type'=>'affliation_relationship'])
            ->asArray()->all();

        if (Yii::$app->request->isPost) {
            $reponse = Yii::$app->request->post();
            $reponse_employment = $reponse[Employment::className()];
            if($reponse_employment['street_2']!='受雇'){
                $reponse_employment['country'] = '';
                $reponse_employment['affliation_company_country'] = '';
            }else if($reponse_employment['street_2']=='受雇' && $reponse_employment['affiliation']==0){
                $reponse_employment['affliation_company_country'] = '';
            }
            $condition = ['Customer_id' => $customer_id];

            $employmentLogic = new EmploymentLogic();
            $employmentLogic->SaveEmployment($condition, $reponse_employment);
            return $this->redirect(Url::to(['account/index']));
//            return $this->redirect(Url::to(['info/employinfo', 'Customer_id'=> $customer_id]));
        }

        return $this->render('employinfo', [
            'Customer_id' => $customer_id,
            'employStatus' => json_encode($employStatus),
            'employment' => $employment,
            'state' => json_encode($state),
            'city' => json_encode($city),
            'embs' => json_encode($em_bs),
            'emoc' => json_encode($em_oc),
            'rel' => json_encode($rel),
            'data' => $data,
        ]);
    }
}