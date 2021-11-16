<?php
namespace frontend\controllers;

use common\models\Candidate;
use common\models\Country;
use common\models\Phone;
use common\models\Resident;
use common\models\Tax;
use frontend\Logic\CandidateLogic;
use frontend\Logic\ResidentLogic;
use frontend\Logic\TaxLogic;
use Yii;
use yii\helpers\Url;

class InfoController extends BaseController
{
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

    public function actionPersoninfo(){
        $customer_id = Yii::$app->request->get('Customer_id', '');

        $data = [];
        $candidate = Candidate::findOne(['Customer_id' => $customer_id]);
        if (!$candidate)
            $candidate = new Candidate();

        $tax = Tax::findOne(['Customer_id' => $customer_id]);
        if (!$tax)
            $tax = new Tax();

        if (Yii::$app->request->isPost) {
            $reponse = Yii::$app->request->post();
            $reponse_candidate = $reponse[Candidate::className()];
            $reponse_tax = $reponse[Tax::className()];
            $condition = ['Customer_id' => $customer_id];

            $candidateLogic = new CandidateLogic();
            $candidateLogic->UpdateCandidate($condition, $reponse_candidate);

            $taxLogic = new TaxLogic();
            $taxLogic->SaveTax($condition,$reponse_tax);
            return $this->redirect(Url::to(['account/index']));
//            return $this->redirect(Url::to(['info/personinfo', 'Customer_id'=> $customer_id]));
        }

        return $this->render('personinfo', [
            'candidate'  => $candidate,
            'tax'        => $tax,
            'Customer_id'=>$customer_id,
            'data' =>$data
        ]);
    }

}