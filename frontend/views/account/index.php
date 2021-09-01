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

//$this->registerMetaTag(['name' => 'keywords', 'content' => '瓜子tv,澳洲瓜子tv,新西兰瓜子tv,澳新瓜子tv,瓜子视频,瓜子影视,电影,电视剧,榜单,综艺,动画,记录片']);
$this->title = '首页-财猫证券开户';
AppAsset::register($this);

$js = <<<JS
$(function(){
    let identity_url = 'https://api.moneycatrading.com/index.php?app=member&act=sendmsg';
    $('#identity-btn').click(function (){
        var phone = $('#phone').val();
        var country = $('#country').val();
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
    })
});
JS;

$this->registerJs($js);

?>

    <style>
        .phone{
            height: auto;
        }

        .phone input{
            height: 50px;
        }

        .form-group{
            height: 100%;
        }

        .help-block{
            color: red;
        }


    </style>

    <div class="banner">
        <img src="/img/banner.jpg" />
    </div>
    <div class="title">
        <div class="logo">
            <img src="/img/logo.png" />
        </div>
        <div>手机号验证</div>
    </div>
    <div class="process">
        <div class="process-top">
            <img src="/img/18.png" />
        </div>
        <div class="process-bow">
            <div>
                &nbsp;
            </div>
        </div>
    </div>

<?php $form = ActiveForm::begin([
    'id' => 'contact-form',
    'enableClientValidation' => false,
//    'enableAjaxValidation' => true,
]) ?>
    <div class="title-name">手机号</div>
    <div class="phone">
        <div class="phone-country">
            <?= $form->field($model, 'country')->dropDownList(Phone::$countrys, ['id'=>'country'])->label(false) ?>
        </div>
        <div class="phone-num">
            <?= $form->field($model, 'number')->textInput(['maxlength' => 11, 'placeholder' => '您的手机号', 'pattern'=>"[0-9]*", 'id'=>'phone'])->label(false) ?>
        </div>
        <div class="phone-btn">
            <!-- input和div 隐藏样式class="divHide" -->
            <input id='identity-btn' type="button" value="获取验证码" />
            <div id='identity-count' class="divHide">
                <span>60</span>后秒重试
            </div>
        </div>
    </div>

    <div class="title-name">验证码</div>
    <div class="phone">
<!--        <input type="text" class="inpttext" placeholder="请输入收到的验证码" pattern="[0-9]*" maxlength="6" />-->
        <?= $form->field($model, 'identity_code')->textInput(['maxlength' => 6, 'placeholder' => '请输入收到的验证码', 'pattern'=>"[0-9]*", 'class'=>'inpttext'])->label(false) ?>
    </div>

    <!-- div 隐藏样式class="divHide" -->
    <div class="errors divHide">
        <div class="errors-img">
            <img src="/img/remind-Red.png" />
        </div>
        <div class="errors-text colorRed">验证码输入错误,请查询后重新输入</div>
    </div>
    <div class="rule-01">
        <div class="rule-01-left">
            <img src="/img/IDicon.png" />
        </div>
        <div class="rule-01-right">若为中国大陆居民，请准备好本人国内二代居民身份证，以免影响开户进度</div>
    </div>
    <div class="rule-01">
        <div class="rule-01-left">
            <img src="/img/passport-o.png" />
        </div>
        <div class="rule-01-right">若为国外居民，请准备好驾照或护照</div>
    </div>
    <div class="rule-01">
        <div class="rule-01-left">
            <img src="/img/wifi.png" />
        </div>
        <div class="rule-01-right">开户前请确保网络连接畅通</div>
    </div>
    <div class="box-01">
        <div class="box-01-bth">
            <input type="submit" class="inptbtn colorWhite" value="下一步" />
        </div>
        <div class="box-01-a">登录注册即表示同意&nbsp;<a class="colorOrange " href="#">隐私协议</a></div>
    </div>

<?php ActiveForm::end() ?>