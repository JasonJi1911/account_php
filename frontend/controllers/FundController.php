<?php

namespace frontend\controllers;

use common\helpers\Tool;
use common\models\Country;
use common\models\Deposit;
use common\models\Identity;
use common\models\Regulatory;
use frontend\Logic\IdentityLogic;
use frontend\Logic\InfoLogic;
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

class FundController extends BaseController
{
    public function actionDeposit()
    {
        $uid = Yii::$app->request->get('uid', '');
        $account = Yii::$app->request->get('account', '');
        $deposit = Deposit::findOne(['uid' => $uid]);
        if(!$deposit)
            $deposit = new Deposit();

        if (!$account){
            $candidateLogic = new CandidateLogic();
            $candidate = $candidateLogic->GetCandidateByUid($uid);
            $account = $candidate['tradingAccount'];
        }
        $isNew = 1;
        $saveModel = new Deposit();
        if (Yii::$app->request->isPost && $saveModel->load(Yii::$app->request->post())) {
            if ($saveModel->validate()) {
                $res = Tool::httpPost('https://api.moneycatrading.com/index.php?app=fund&act=deposit_funds',
                    ['acctId'=>$account, 'amount'=>$saveModel->amount, 'currency'=>$saveModel->currency, 'bank_number'=>$saveModel->bankAccount,
                        'bank_name'=>$saveModel->bankName]);
                if ($saveModel->isSave == "1")
                {
                    $saveModel->oldAttributes = $deposit->oldAttributes;
                    $saveModel->uid = $uid;
                    $saveModel->save(false);
                }
                $isNew = 0;
                $res_data = json_decode($res['data'], true);
                if (!$res_data['data'])
                    $message = '入金通知失败';
                else
                    $message = '入金通知'.$res_data['message'];
            }
        }

        if ($isNew == 0)
            $deposit = $saveModel;

        return $this->render('index', [
            'account' => $account,
            'model'=>$deposit,
            'isNew'=>$isNew,
            'message' => $message,
        ]);
    }
}