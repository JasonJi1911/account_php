<?php

namespace frontend\controllers;

use common\helpers\Tool;
use common\models\Identity;
use frontend\Logic\IdentityLogic;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Cookie;
use yii\helpers\ArrayHelper;
use common\models\Phone;
use common\models\Candidate;
use yii\widgets\ActiveForm;
use yii\web\Response;
use frontend\Logic\CandidateLogic;

/**
 * Account controller
 */
class AccountController extends BaseController
{
    private function SwitchTag($customer_id, $current_step)
    {
        $candidateLogic = new CandidateLogic();
        if($customer_id)
        {
            $step =  $candidateLogic->SwitchTag($customer_id);
            if($step != $current_step)
            {
                $pageTab = Yii::$app->params['pageTab'];
                return $this->redirect(Url::to(['account/'.$pageTab[$step], 'Customer_id'=> $customer_id]));
            }
        }
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

    public function actionIndex()
    {
        $customer_id = Yii::$app->request->get('Customer_id', '');
        $this->SwitchTag($customer_id, TAB_INDEX);

        $model = new Phone();
        $candidate = new Candidate();
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $candidate->Customer_id = time();
                $candidate->external_id = "moneycat" . $candidate->Customer_id;
                $candidate->step = TAB_INDEX;
                $candidateLogic = new CandidateLogic();
                $result = $candidateLogic->RegisterNewCandidate($model->attributes, $candidate->attributes);
                if ($result['status'] != 200)
                    $model->addError('number', $result['message']);
                else {
                    $customer_id = $result['Customer_id'];
                    $step =  $candidateLogic->SwitchTag($customer_id);
                    $pageTab = Yii::$app->params['pageTab'];
                    return $this->redirect(Url::to(['account/'.$pageTab[$step], 'Customer_id'=> $customer_id]));
                }
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionTips()
    {
        $customer_id = Yii::$app->request->get('Customer_id', '');

        $result = $this->ValidateCustomer($customer_id);
        if(!$result)
            return $this->redirect(Url::to(['/site/error']));

        $data = ['step' => TAB_TIPS];
        $candidateLogic = new CandidateLogic();
        $candidateLogic->UpdateStep($customer_id, $data);
        return $this->render('tips', [
            'Customer_id' => $customer_id,
        ]);
    }

    public function actionNationality()
    {
        $customer_id = Yii::$app->request->get('Customer_id', '');

        $candidate = new Candidate();
        $identity = new Identity();
        $identity->Customer_id = $customer_id;
        $candidateLogic = new CandidateLogic();
        $identityLogic = new IdentityLogic();

        if (Yii::$app->request->isPost) {
            $reponse = Yii::$app->request->post();
            $reponse_candidate = $reponse[Candidate::className()];
            $reponse_identity = $reponse[Identity::className()];
            $identity->type = $reponse_identity['type'];
            $condition = ['Customer_id' => $customer_id];
            $candidateLogic->UpdateCandidate($condition, ['citizenship' => $reponse_candidate['citizenship']]);
            $identityLogic->InsertNewIdentity($identity->attributes);
            if($candidate->same_citizen == $candidate::SAME_CITIZEN_YES)
            {

            }
            return $this->redirect(Url::to(['account/identity', 'Customer_id'=> $customer_id]));
        }
        else
        {
            $result = $this->ValidateCustomer($customer_id);
            if(!$result)
                return $this->redirect(Url::to(['/site/error']));

            $data = ['step' => TAB_NATIONALITY];
            $candidateLogic->UpdateStep($customer_id, $data);
        }

        return $this->render('nationality', [
            'candidate' => $candidate,
            'identity' => $identity,
        ]);
    }

    public function actionIdentity()
    {

    }
}