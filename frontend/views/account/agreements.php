<?php

use yii\helpers\Url;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

//$this->registerMetaTag(['name' => 'keywords', 'content' => 'xxxx']);
$this->title = '财猫证券开户';
AppAsset::register($this);
?>

<style>
    .spinner {
        /* margin: 100px auto; */
        width: 200px;
        height: 80px;
        text-align: center;
        font-size: 10px;
        top: 50%;
        left: 25%;
        position: fixed;
        display: none;
    }

    .spinner .ani {
        background-color: #EF7E2E;
        height: 100%;
        width: 6px;
        display: inline-block;

        -webkit-animation: stretchdelay 1.2s infinite ease-in-out;
        animation: stretchdelay 1.2s infinite ease-in-out;
    }

    .spinner .rect2 {
        -webkit-animation-delay: -1.1s;
        animation-delay: -1.1s;
    }

    .spinner .rect3 {
        -webkit-animation-delay: -1.0s;
        animation-delay: -1.0s;
    }

    .spinner .rect4 {
        -webkit-animation-delay: -0.9s;
        animation-delay: -0.9s;
    }

    .spinner .rect5 {
        -webkit-animation-delay: -0.8s;
        animation-delay: -0.8s;
    }

    @-webkit-keyframes stretchdelay {
        0%, 40%, 100% { -webkit-transform: scaleY(0.4) }
        20% { -webkit-transform: scaleY(1.0) }
    }

    @keyframes stretchdelay {
        0%, 40%, 100% {
            transform: scaleY(0.4);
            -webkit-transform: scaleY(0.4);
        }  20% {
               transform: scaleY(1.0);
               -webkit-transform: scaleY(1.0);
           }
    }
    /****************/
    input[type='checkbox'] {
        position: relative;
        cursor: pointer;
        width: 15px;
        height: 15px;
        font-size: 12px;

    }

    input[type='checkbox']:checked::after {
        position: absolute;
        top: 0;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 15px;
        height: 15px;
        content: '';
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        background: url(/img/checked.png) no-repeat;
        background-size: 100% 100%;
        border-radius: 2px;
    }
    .signBox{
        width:100%;
        height:3.5rem;
        box-sizing:border-box;
        border: 1px solid #EEEEEE;
        padding-left:10px;
    }
    a{
        text-decoration: none;
        color:#0547C1 ;
    }

    .fileInput{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        margin: 0;
        font-size: 23px;
        cursor: pointer;
        filter: alpha(opacity=0);
        opacity: 0;
        direction: ltr;
    }
</style>
<script type="text/javascript" src="/js/vue@2.js"></script>

<div id="vertify">
    <div class="bold f40 color272727 m1T m1L">协议与披露</div>
    <div class="flexBox1 color878787 f24 m1L m1R m05B m05T">请花一些时间阅读以下协议和披露</div>

    <div class="flexBox1 m1L m1R m1T" v-for="item in list1">
        <a :href="item.value" class="color0547C1 m1R">{{item.title}}</a>
        <div class="flexBox1">
            <input checked type="checkbox" name="btn1" class="btn1"/>
            <div class="f24 color878787 cenetr" style="min-width:30px;">同意</div>
        </div>
    </div>

    <div class="f33 color303030 m1L m1R m15T">用户确认: <?= $data['first_name']?> <?= $data['last_name']?></div>
    <div class="m1L m1R m1T">
        <input placeholder="在此处签名" class="signBox" required/>
    </div>
    <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 m05T">需与上方显示的名称完全一致</div>
    <div class="flexBox1 m1L m1R m1T wBtnBox m2B" id="signature">
        <div class="prevBtn borderCACACA color000 bgffffff cenetr radius20px f33 p05T p05B relative">
            上一步
            <a href="<?= Url::to(['sure-info', 'Customer_id' => $Customer_id])?>" class="fileInput"></a>
        </div>
        <div class="nextBtn f33 bgEF7E2E colorFFF cenetr  p05T p05B radius20px" @click="nextSubmit()">
            下一步
        </div>
    </div>
</div>

<div class="spinner">
    <div class="spintitle"> 处理中...</div>
    <div class="rect1 ani"></div>
    <div class="rect2 ani"></div>
    <div class="rect3 ani"></div>
    <div class="rect4 ani"></div>
    <div class="rect5 ani"></div>
</div>

<script type="text/javascript">
    new Vue({
        el:"#vertify" ,
        data:{
            list1:[
                {'title':'Legal Acknowledgement','value':'http://pdf.moneycatrading.com/agreements/Form2109.pdf'},
                {'title':'Notice and Acknowledgement of Clearing Arrangement','value':'http://pdf.moneycatrading.com/agreements/Form3058.pdf'},
                {'title':'Global Financial Information Services Subscriber Agreement','value':'http://pdf.moneycatrading.com/agreements/Form3089.pdf'},
                {'title':"Notice Regarding NFA's BASIC System",'value':'http://pdf.moneycatrading.com/agreements/Form3094.pdf'},
                {'title':'IB Australia Pty Ltd General Terms and Conditions','value':'http://pdf.moneycatrading.com/agreements/Form3300.pdf'},
                {'title':'BNP Clearing Disclosure Statement','value':'http://pdf.moneycatrading.com/agreements/Form3301.pdf'},
                {'title':'IB Australia Pty Ltd Financial Services Guide','value':'http://pdf.moneycatrading.com/agreements/Form3302.pdf'},
                {'title':'IB Australia Pty Ltd Disclosure For FOREX Contracts','value':'http://pdf.moneycatrading.com/agreements/Form3303.pdf'},
                {'title':'IB Australia Pty Ltd Disclosure For Exchange Trade Options','value':'http://pdf.moneycatrading.com/agreements/Form3304.pdf'},
                {'title':'IB Australia Pty Ltd Disclosure For Futures Contracts','value':'http://pdf.moneycatrading.com/agreements/Form3305.pdf'},
                {'title':'ASX Explanatory Booklet for Options','value':'http://pdf.moneycatrading.com/agreements/Form3306.pdf'},
                {'title':'ASX Explanatory Booklet for Warrants','value':'http://pdf.moneycatrading.com/agreements/Form3307.pdf'},
                {'title':'ASX Explanatory Booklet for Low Exercise Put Options (LEPOs)','value':'http://pdf.moneycatrading.com/agreements/Form3308.pdf'},
                {'title':'ASX Client Clearing Service for Derivatives - Fact Sheet','value':'http://pdf.moneycatrading.com/agreements/Form3309.pdf'},
                {'title':'BNP Financial Services Guide','value':'http://pdf.moneycatrading.com/agreements/Form3310.pdf'},
                {'title':'IB Australia Pty Ltd Privacy Statement','value':'http://pdf.moneycatrading.com/agreements/Form3311.pdf'},
                {'title':'Australia Regulatory Questionnaire','value':'http://pdf.moneycatrading.com/agreements/Form3315.pdf'},
                {'title':'Chi-X Australia Warrant Booklet','value':'http://pdf.moneycatrading.com/agreements/Form3316.pdf'},
                {'title':'IB Australia Pty Ltd Best Execution Policy','value':'http://pdf.moneycatrading.com/agreements/Form3317.pdf'},
                {'title':'Third Party Authority Form and Limited Power of Attorney','value':'http://pdf.moneycatrading.com/agreements/Form3322.pdf'},
                {'title':'Interactive Brokers APAC Order Routing Disclosure','value':'http://pdf.moneycatrading.com/agreements/Form4305.pdf'},
                {'title':'Trading Control and Ownership Certification','value':'http://pdf.moneycatrading.com/agreements/Form5013.pdf'},
                {'title':'Algorithmic Execution Venue Disclosure','value':'http://pdf.moneycatrading.com/agreements/Form4070.pdf'},
                {'title':'Stock Stop Order Disclosure','value':'http://pdf.moneycatrading.com/agreements/Form9130.pdf'},
                {'title':'Hong Kong Risk Disclosure','value':'http://pdf.moneycatrading.com/agreements/Form4041.pdf'},
            ],
        },
        methods:{
            nextSubmit:function (){
                var agreeAll = 1;
                $('.btn1').each(function (){
                    if (!$(this).is(':checked'))
                    {
                        agreeAll = 0;
                        return;
                    }
                });
                if (agreeAll == 0)
                {
                    alert("必须同意所有的协议才能完成开户");
                    return;
                }
                $('.spinner').show();
                var arrIndex = {};
                arrIndex['Customer_id'] = '<?= $Customer_id?>';
                $.get('/account/submit-application', arrIndex, function(s) {
                    var realData = s.data;
                    console.log(realData);
                    if (realData.status == 1 )
                    {
                        $('.spinner').hide();
                        alert("开户失败，请检查填写的信息");
                        return;
                    }
                    console.log(realData.data);
                    if(realData.data == undefined)
                    {
                        $('.spinner').hide();
                        alert("网络波动，请稍后再试");
                        return;
                    }

                    console.log(realData.data.accountType);
                    console.log(realData.data.tradingAccount);
                    var accountType = realData.data.accountType;
                    var account = realData.data.tradingAccount;
                    arrIndex['account_id'] = account;
                    $.get('/account/submit-application', arrIndex, function(s) {

                    });
                    window.location.href = "/info/success?Customer_id="+<?= $Customer_id?>+"&accountType="+accountType+"&account="+account;
                });
                var int=self.setInterval(this.tickleData,1000);
            },
            tickleData:function ()
            {
                var arrIndex = {};
                arrIndex['Customer_id'] = '<?= $Customer_id?>';
                $.get('/account/fetch-account', arrIndex, function(s) {
                    var realData = s.data;
                    console.log(realData);
                    if (realData.status == 1)
                        return;

                    if (realData.status == 500)
                    {
                        $('.spinner').hide();
                        alert("网络波动，请稍后再试");
                        return;
                    }

                    var accountType = realData.data.accountType;
                    var account = realData.data.tradingAccount;
                    arrIndex['account_id'] = account;
                    $.get('/account/submit-application', arrIndex, function(s) {

                    });
                    window.location.href = "/info/success?Customer_id="+<?= $Customer_id?>+"&accountType="+accountType+"&account="+account;
                });
            }
        }
    });
</script>
