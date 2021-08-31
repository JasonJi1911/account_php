<?php

namespace frontend\controllers;

use common\helpers\Tool;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Cookie;
use yii\helpers\ArrayHelper;
use common\models\Phone;
use yii\widgets\ActiveForm;
use yii\web\Response;

/**
 * Site controller
 */
class AccountController extends BaseController
{
    public function actionIndex()
    {
        $model = new Phone();
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->isPost){
            return $this->redirect('identity');
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionIdentity()
    {

    }
}