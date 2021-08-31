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

?>

    <style>
        .form-group{
            height: 100%;
        }

        .help-block{
            color: red;
        }

        .phone{
            overflow: unset;
        }
    </style>

    <div class="banner">
        <img src="img/banner.jpg" />
    </div>
    <div class="title">
        <div class="logo">
            <img src="img/logo.png" />
        </div>
        <div>手机号验证</div>
    </div>
    <div class="process">
        <div class="process-top">
            <img src="img/18.png" />
        </div>
        <div class="process-bow">
            <div>
                &nbsp;
            </div>
        </div>
    </div>

<?php $form = ActiveForm::begin([
    'id' => 'contact-form',
    'enableAjaxValidation' => true,
]) ?>
    <div class="title-name">手机号</div>
    <div class="phone">
        <div class="phone-country">
            <?= $form->field($model, 'country')->dropDownList(Phone::$countrys)->label(false) ?>
        </div>
        <div class="phone-num">
            <?= $form->field($model, 'number')->textInput(['maxlength' => 11, 'placeholder' => '您的手机号', 'pattern'=>"[0-9]*"])->label(false) ?>
        </div>
        <div class="phone-btn">
            <!-- input和div 隐藏样式class="divHide" -->
            <input type="button" value="获取验证码" />
            <div class="divHide">
                <span>60</span>后秒重试
            </div>
        </div>
    </div>

    <div class="title-name">验证码</div>
    <div class="phone">
        <input type="text" class="inpttext" placeholder="请输入收到的验证码" pattern="[0-9]*" maxlength="6" />
    </div>

    <!-- div 隐藏样式class="divHide" -->
    <div class="errors ">
        <div class="errors-img">
            <img src="img/remind-Red.png" />
        </div>
        <div class="errors-text colorRed">验证码输入错误,请查询后重新输入</div>
    </div>
    <div class="rule-01">
        <div class="rule-01-left">
            <img src="img/IDicon.png" />
        </div>
        <div class="rule-01-right">若为中国大陆居民，请准备好本人国内二代居民身份证，以免影响开户进度</div>
    </div>
    <div class="rule-01">
        <div class="rule-01-left">
            <img src="img/passport-o.png" />
        </div>
        <div class="rule-01-right">若为国外居民，请准备好驾照或护照</div>
    </div>
    <div class="rule-01">
        <div class="rule-01-left">
            <img src="img/wifi.png" />
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