<?php
use yii\helpers\Url;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

//$this->registerMetaTag(['name' => 'keywords', 'content' => '瓜子tv,澳洲瓜子tv,新西兰瓜子tv,澳新瓜子tv,瓜子视频,瓜子影视,电影,电视剧,榜单,综艺,动画,记录片']);
$this->title = '证件提示-财猫证券开户';
AppAsset::register($this);
?>

<div class="banner">
    <img src="/img/banner.jpg" />
</div>
<div class="text-02 textBold">
    开户前请做好一下准备
</div>
<div class="tips-01">
    <div class="tips-01-left">
        <img src="/img/IDicon-w.png" />
    </div>
    <div class="tips-01-right">
        <div class="tips-Bold">
            身份证（正反面照片）
        </div>
        <div class="colorGrey">
            身份证原件或正反面照片，证件在有效期内且已年满18岁。
        </div>
    </div>
</div>
<div class="tips-01">
    <div class="tips-01-left">
        <img src="/img/passport-w.png" />
    </div>
    <div class="tips-01-right">
        <div class="tips-Bold">
            驾照或护照
        </div>
        <div class="colorGrey">
            若为国外用户请准备驾照或护照原件，证件在有效期内且已年满18岁。
        </div>
    </div>
</div>
<div class="tips-01">
    <div class="tips-01-left">
        <img src="/img/wifi-w.png" />
    </div>
    <div class="tips-01-right">
        <div class="tips-Bold">
            良好网络链接
        </div>
        <div class="colorGrey">
            建议使用Wi-Fi，或3G/4G。
        </div>
    </div>
</div>
<div class="tips-box">
    <div class="box-01-bth matop">
        <input type="button" class="inptbtn colorWhite" value="我准备好了"
               onclick='location.href=("<?= Url::to(['nationality', 'Customer_id' => $Customer_id])?>")' />
    </div>
    <div class="colorGrey">
        暂不开户
    </div>
</div>

