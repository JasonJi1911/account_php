<?php
use yii\helpers\Url;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

//$this->registerMetaTag(['name' => 'keywords', 'content' => 'xxxx']);
$this->title = '财猫证券开户';
AppAsset::register($this);

$js = <<<JS
$(function(){
    $("#next").click(function (){
        location.href = $(this).attr('data-link');
    });
});
JS;

$this->registerJs($js);
?>

<div class="f40 color272727 m53-37 bold">开户前请您准备</div>
<div class="m1L m1T flexBox2 m1R m2B">
    <img src="/img/icon_6.png" class="W31"/>
    <div class="m1L">
        <p class="f38 color000 fontWeight400">身份证件</p>
        <p class="f33 color656565 m05T">请准备好身份证件，澳洲驾照(推荐）、澳洲photo ID或澳洲护照。</p>
    </div>
</div>
<div class="flexBox2 m1L m1T m1R">
    <img src="/img/icon_5.png" class="W31"/>
    <div class="m1L">
        <p class="f38 color000">良好的网络链接</p>
        <p class="f33 color656565 m05T">建议使用Wi－Fi，或4G / 5G。</p>
    </div>
</div>
<div class="fixed bottom w100_ m1L m1R" id="btn-group">
    <div class="f33 bgEF7E2E colorFFF cenetr p05T p05B radius20px m05B borderEF7E2E"
         data-link="<?= Url::to(['nationality', 'Customer_id' => $Customer_id])?>"
         id="next">
        我准备好了
    </div>
    <div class="f33 bgffffff borderEF7E2E colorEF7E2E cenetr p05T p05B radius20px" @click="closePage">
        暂不开户
    </div>
</div>

<script type="module">
    import {viewPageDismiss} from '/js/utils.js'
    new Vue({
        el:"#btn-group" ,
        data:{

        },
        mounted:function(){

        },
        methods:{
            closePage:function ()
            {
                viewPageDismiss('{reload:false}');
            },
        }
    });
</script>

