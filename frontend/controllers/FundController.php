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

        if (Yii::$app->request->isPost && $deposit->load(Yii::$app->request->post())) {
            if ($deposit->validate()) {
                $deposit->uid = $uid;
                $deposit->save(false);
            }
        }
        return $this->render('index', [
            'account' => $account,
            'model'=>$deposit,
        ]);
    }
}