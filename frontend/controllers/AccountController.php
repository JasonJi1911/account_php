<?php

namespace frontend\controllers;

use common\helpers\Tool;
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
    public function actionIndex()
    {
        $model = new Phone();
        $candidate = new Candidate();
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $candidate->Customer_id = time();
                $candidate->external_id = "moneycat" . $candidate->Customer_id;
                $candidate->step = 0;
                $candidateLogic = new CandidateLogic();
                $result = $candidateLogic->RegisterNewCandidate($model->attributes, $candidate->attributes);
                if ($result['status'] != 200)
                    $model->addError('number', $result['message']);
                else {
                    $customer_id = $result['Customer_id'];
                    $step =  $candidateLogic->SwitchTag($customer_id);
                    $pageTab = Yii::$app->params['pageTab'];
                    return $this->redirect('account/'.$pageTab[$step]);
                }
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionTips()
    {
        return $this->render('tips', [
        ]);
    }

    public function actionNationality()
    {

    }

    public function actionIdentity()
    {

    }
}