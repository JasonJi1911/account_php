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

$this->title = '财猫证券开户';
AppAsset::register($this);

$js = <<<JS
$(function(){
    let identity_url = 'https://api.moneycatrading.com/index.php?app=member&act=sendmsg';
    $('#identity-btn').click(function (){
        var phone = $('#phone').val();
        var country = $('#haveSj').val();
        var country_code = 86;
        switch (country){
            case 'CHN':
                country_code = 86;
                break;
            case 'AUS':
                country_code = 61;
                break;
            case 'USA':
                country_code = 1;
                break;
        }
        if (phone == '')
        {
            alert('手机号不能为空');
            return false;
        }
        var form = new FormData();
        form.append("tel", phone);
        form.append("country_code", country_code);

        console.log(form);
        var settings = {
          "url": identity_url,
          "method": "POST",
          "timeout": 0,
          "processData": false,
          "mimeType": "multipart/form-data",
          "contentType": false,
          "data": form
        };
        
        $.ajax(settings).done(function (response) {
            $('#identity-count').removeClass('divHide');
            $('#identity-btn').addClass('divHide')
            
            var tin = setInterval(function(){
                $('#identity-count span').text($('#identity-count span').text() - 1);
                if($('#identity-count span').text() == 0)
                {
                    $('#identity-count').addClass('divHide');
                    $('#identity-btn').removeClass('divHide');
                    $('#identity-count span').text(60)
                    clearInterval(tin);
                }
            },1000);
        });
    });
    
    $("#divNext").click(function (){
        $('#next').trigger('click');
    });
});
JS;

$this->registerJs($js);

?>

<style>
    input::-webkit-input-placeholder{
        color: #ADADAD;
    }

    #haveSj {
        border: 0;
        outline: none;
        display: block;
        position: relative;
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        line-height: 1.5rem;
    }

    .help-block_padding {
        padding-bottom: 0.5rem;
        padding-top: 0.5rem;
    }
    .arrowimg{
        width:10px;
        height:10px;
        margin-top: 5px;
    }
</style>

<div class="color272727 f40 p1L p1T p1B bold">手机号验证</div>
<div class="colorEF7E2E p1L p1T p1B bgF8F8F8 flexBox2">
    <img src="/img/icon_1.png" class="phoneIcon"/>
    <span class="f33">&nbsp手机号</span>
</div>

<?php $form = ActiveForm::begin([
    'id' => 'contact-form',
    'enableClientValidation' => true,
//    'enableAjaxValidation' => true,
]) ?>
    <div class="f33 m1L borderB p1R p1T p1B flexBox1">
        <div class="flexBox2">
            <?= $form->field($model, 'country')->dropDownList(Phone::$countrys, ['id'=>'haveSj', 'class' => 'color474747'])->label(false) ?>
            <img src="/img/downarrow.jpg" class="relative arrowimg" />
<!--            <div class="sj relative" style="top:8px;left:3px;"></div>-->
            &nbsp;&nbsp;&nbsp;
<!--            <input placeholder="请输入您的手机号" value="" class="color474747 f33"/>-->
            <?= $form->field($model, 'number')
                ->textInput(['maxlength' => 11, 'placeholder' => '请输入您的手机号', 'pattern'=>"[0-9]*", 'id'=>'phone', 'class' => 'color474747 f33'])
                ->label(false)->error(['class'=> $model->hasErrors('number') ? "help-block  help-block_padding": 'help-block']) ?>
        </div>
        <span class="colorEF7E2E f33" id='identity-btn'>获取验证码</span>
        <div id='identity-count' class="olorEF7E2E f33 divHide">
            <span>60</span>后秒重试
        </div>
    </div>
    <div class="f33 m1L borderB p1R p1T p1B">
        <?= $form->field($model, 'identity_code')
            ->textInput(['maxlength' => 6, 'placeholder' => '请输入验证码', 'pattern'=>"[0-9]*", 'class'=>'color474747 f33 w100'])
            ->label(false)->error(['class'=> $model->hasErrors('identity_code') ? "help-block  help-block_padding": 'help-block']) ?>
    </div>
    <div class="color999 f24 m1L m1R p1T flexBox2">
        <img src="/img/icon_2.png" class="icon1" style="height:13px;"/>
        <div class="m05L">请您准备好澳洲有效证件：澳洲驾照（推荐）、澳洲 photoID或澳洲护照。</div>
    </div>
    <div class="color999 f24 m1L p1T">
        <img src="/img/icon_3.png" class="icon1"/>
        &nbsp;开户前请确认网络连接正常。
    </div>
    <div class="f24 m1L p1T color999 flexBox2">
        <img src="/img/icon_4.png" class="icon1"/>
        &nbsp;&nbsp;绑定已有财猫交易账号（无需开户）。
    </div>
    <input type="submit" class="divHide" id="next">
    <div class="f33 bgEF7E2E colorFFF cenetr m1L m1R p05T p05B radius20px fixed bottom w100_" id="divNext">
        下一步
    </div>

<?php ActiveForm::end() ?>