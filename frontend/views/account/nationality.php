<?php
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
<div class="title-b matop">国家/地区
</div>
<div class="box-select">
    <div class="box-select-left">国籍</div>
    <div class="box-select-right">
        <select name="">
            <option value="">中国大陆</option>
            <option value="">泰国</option>
            <option value="">新西兰</option>
            <option value="">菲律宾</option>
            <option value="">韩国</option>
        </select>
    </div>
</div>
<div class="box-select">
    <div class="box-select-left">证件类型</div>
    <div class="box-select-right">
        <select name="">
            <option value="">身份证</option>
            <option value="">驾照</option>
            <option value="">护照</option>
        </select>
    </div>
</div>
<div class="bow-bth-01">
    <div class="text-01">
        <input type="checkbox" checked='checked' name="" id="" value="" />
        <label for="">确认本人
            <span class="colorOrange ">国籍、出生国、居住国、税收居民国/地区</span> 都是该国家/地区；如不满足上述条件，或您为多个郭建/地区的税收居民，无需勾选，请点击“下一步”并提供相关证明材料。
        </label>
    </div>

    <div class="box-01-bth matop">
        <input type="button" class="inptbtn colorWhite" value="确认，下一步" onclick='location.href=("IDcard.html")' />
    </div>
</div>