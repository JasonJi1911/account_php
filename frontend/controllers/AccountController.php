<?php

namespace frontend\controllers;

use common\helpers\Tool;
use common\models\Country;
use common\models\Identity;
use common\models\Regulatory;
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
        $uid = Yii::$app->request->get('uid', '');
        if (!$uid)
            return $this->redirect(Url::to(['/site/error']));

        $this->SwitchTag($customer_id, TAB_INDEX);

        $model = new Phone();
        $candidate = new Candidate();
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $candidate->uid = $uid;
                $candidate->Customer_id = time();
                $candidate->external_id = "mcat" . $candidate->Customer_id;
                $candidate->step = TAB_INDEX;
                $candidateLogic = new CandidateLogic();
                $model->type = "Mobile";
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

        $candidate = Candidate::findOne(['Customer_id' => $customer_id]);
        if (!$candidate)
            $candidate = new Candidate();

        $identity = Identity::findOne(['Customer_id' => $customer_id]);
        if (!$identity)
        {
            $identity = new Identity();
            $identity->Customer_id = $customer_id;
        }

        $candidateLogic = new CandidateLogic();
        $identityLogic = new IdentityLogic();

        if (Yii::$app->request->isPost) {
            $reponse = Yii::$app->request->post();
            $reponse_candidate = $reponse[Candidate::className()];
            $reponse_identity = $reponse[Identity::className()];
            $identity->type = $reponse_identity['type'];
            $condition = ['Customer_id' => $customer_id];
            $candidateLogic->UpdateCandidate($condition, $reponse_candidate);
            //插入或者更新candidate
            $identityLogic->InsertNewIdentity($identity->attributes);
            return $this->redirect(Url::to(['account/identity-card', 'Customer_id'=> $customer_id]));
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
            'Customer_id' => $customer_id,
            'candidate' => $candidate,
            'identity' => $identity,
        ]);
    }

    public function actionIdentityCard()
    {
        $customer_id = Yii::$app->request->get('Customer_id', '');
        $identity = Identity::findOne(['Customer_id' => $customer_id]);
        if (Yii::$app->request->isPost && $identity->load(Yii::$app->request->post())) {
            $identity->Customer_id = $customer_id;
            $identity->save(false);
            return $this->redirect(Url::to(['account/identity-info', 'Customer_id'=> $customer_id]));
        }
        else
        {
            $candidateLogic = new CandidateLogic();
            $result = $this->ValidateCustomer($customer_id);
            if(!$result)
                return $this->redirect(Url::to(['/site/error']));

            $data = ['step' => TAB_IDENTITYCARD];
            $candidateLogic->UpdateStep($customer_id, $data);
        }

        return $this->render('identitycard', [
            'Customer_id' => $customer_id,
            'identity' => $identity,
        ]);
    }

    public function actionIdentityInfo()
    {
        $identityLogic = new IdentityLogic();
        $customer_id = Yii::$app->request->get('Customer_id', '');
        $identity = Identity::findOne(['Customer_id' => $customer_id]);
        if (Yii::$app->request->isPost && $identity->load(Yii::$app->request->post())) {
            if ($identity->validate())
            {
                $identity->Customer_id = $customer_id;
                //插入或者更新candidate
                $identityLogic->InsertNewIdentity($identity->attributes, true);
                return $this->redirect(Url::to(['info/contactinfo', 'Customer_id'=> $customer_id]));
            }
        }
        else
        {
            $candidateLogic = new CandidateLogic();
            $result = $this->ValidateCustomer($customer_id);
            if(!$result)
                return $this->redirect(Url::to(['/site/error']));

            $data = ['step' => TAB_IDENTITY];
            $candidateLogic->UpdateStep($customer_id, $data);
        }

        $state = Country::find()->select('state_en as des,state_cn as name,state_code as value')
            ->groupBy('state_en,state_cn,state_code')->asArray()->all();

        return $this->render('identityinfo', [
            'Customer_id' => $customer_id,
            'identity' => $identity,
            'state'      => json_encode($state),
        ]);
    }

    public function actionRegulatory()
    {
        $customer_id = Yii::$app->request->get('Customer_id', '');
        $regulatory = Regulatory::findOne(['Customer_id' => $customer_id]);
        if (!$regulatory)
        {
            $regulatory = new Regulatory();
            $regulatory->Customer_id = $customer_id;
        }
        if (Yii::$app->request->isPost && $regulatory->load(Yii::$app->request->post())) {
            if ($regulatory->validate())
            {
                $regulatory->Customer_id = $customer_id;
                //插入或者更新regulatory
                $regulatory->save(true);
                return $this->redirect(Url::to(['sure-info', 'Customer_id'=> $customer_id]));
            }
        }
        else
        {
            $candidateLogic = new CandidateLogic();
            $result = $this->ValidateCustomer($customer_id);
            if(!$result)
                return $this->redirect(Url::to(['/site/error']));

            $data = ['step' => TAB_REGULATORY];
            $candidateLogic->UpdateStep($customer_id, $data);
        }

        return $this->render('regulatory', [
            'Customer_id' => $customer_id,
            'regulatory' => $regulatory,
        ]);
    }

    public function actionSureInfo()
    {
        $customer_id = Yii::$app->request->get('Customer_id', '');
        $result = $this->ValidateCustomer($customer_id);
        if(!$result)
            return $this->redirect(Url::to(['/site/error']));

        $candidateLogic = new CandidateLogic();
        $candiCondition = ['Customer_id' => $customer_id];
        $candiInfo = $candidateLogic->GetCandidateInfo($candiCondition);

        $data = ['step' => TAB_SUREINFO];
        $candidateLogic->UpdateStep($customer_id, $data);
        return $this->render('sureinfo', [
            'Customer_id' => $customer_id,
            'data' => $candiInfo,
        ]);
    }

    public function actionSureSign()
    {
        $customer_id = Yii::$app->request->get('Customer_id', '');
        $result = $this->ValidateCustomer($customer_id);
        if(!$result)
            return $this->redirect(Url::to(['/site/error']));

        $candidateLogic = new CandidateLogic();
        $data = ['step' => TAB_SURESIGN];
        $candidateLogic->UpdateStep($customer_id, $data);
        return $this->render('suresign', [
            'Customer_id' => $customer_id,
        ]);
    }

    public function actionSubmitApplication()
    {
        $customer_id = Yii::$app->request->get('Customer_id', '');
        $res = Tool::httpPost('https://api.moneycatrading.com/index.php?app=account&act=create', ['Customer_id'=>$customer_id]);
        $data = json_decode($res['data'], true);
        return Tool::responseJson(0, '操作成功', $data);
    }

    public function actionSubmission()
    {
        $customer_id = Yii::$app->request->get('Customer_id', '');
        $account_id = Yii::$app->request->get('account_id', '');
        $res = Tool::httpPost('https://api.moneycatrading.com/index.php?app=account&act=DocumentSubmission'
            , ['Customer_id'=>$customer_id, 'account_id'=>$account_id]);
        $data = json_decode($res['data'], true);
        return Tool::responseJson(0, '操作成功', $data);
    }

    public function actionFetchAccount()
    {
        $customer_id = Yii::$app->request->get('Customer_id', '');
        $res = Tool::httpPost('https://api.moneycatrading.com/index.php?app=account&act=fetchAccountInfo'
            , ['Customer_id'=>$customer_id]);
        $data = json_decode($res['data'], true);
        return Tool::responseJson(0, '操作成功', $data);
    }
}