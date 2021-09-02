<?php

use common\models\Identity;
use yii\helpers\Url;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\Candidate;
use common\models\Phone;

/* @var $this yii\web\View */
/* @var $model common\models\Phone */
/* @var $form yii\widgets\ActiveForm */

$this->title = '地址-财猫证券开户';
AppAsset::register($this);
?>
<div class="step">
    <div class="step-01">
        &nbsp;
    </div>
</div>
<?php $form = ActiveForm::begin([
    'id' => 'identity-form',
    'enableClientValidation' => true,
//    'enableAjaxValidation' => true,
]) ?>
<div class="title-b matop">国家/地区
</div>
<div class="box-select">
    <div class="box-select-left">国籍</div>
    <div class="box-select-right">
        <?= $form->field($candidate, 'citizenship')->dropDownList(Candidate::$citizenships)->label(false) ?>
    </div>
</div>
<div class="box-select">
    <div class="box-select-left">证件类型</div>
    <div class="box-select-right">
        <?= $form->field($identity, 'type')->dropDownList(Identity::$types)->label(false) ?>
    </div>
</div>
<div class="bow-bth-01">
    <div class="text-01">
        <?= $form->field($candidate, 'same_citizen')->checkbox()->label(false) ?>
        <input type="checkbox" checked='checked' name="" id="" value="" />
        <label for="">确认本人
            <span class="colorOrange ">国籍、出生国、居住国、税收居民国/地区</span> 都是该国家/地区；如不满足上述条件，或您为多个郭建/地区的税收居民，无需勾选，请点击“下一步”并提供相关证明材料。
        </label>
    </div>

    <div class="box-01-bth matop">
        <input type="submit" class="inptbtn colorWhite" value="确认，下一步" />
    </div>
</div>
<?php ActiveForm::end() ?>