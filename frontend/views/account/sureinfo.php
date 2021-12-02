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
<!--<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>-->
<script type="text/javascript" src="/js/vue@2.js"></script>
<div id="vertify">
    <div class="bold f40 color272727 m1T m1L m1B">阅读&签署协议</div>
    <div class="bold f40 color272727 m1T m1L m1B">第一账户持有人信息</div>
    <div class="flexBox1 color232323 f33 m1L m1R m05B" v-for="item in list1">
        <span>{{item.title}}</span>
        <span>{{item.value}}</span>
    </div>
    <div class="bold f40 color272727 m1T m1L m1B">财务信息</div>
    <div class="flexBox1 color232323 f33 m1L m1R m05B" v-for="item in list2">
        <span>{{item.title}}</span>
        <span>{{item.value}}</span>
    </div>
    <div class="bold f40 color272727 m1T m1L m1B">财富来源</div>
    <div class="flexBox1 color232323 f33 m1L m1R m05B" v-for="item in list3">
        <span>{{item.title}}</span>
        <span>{{item.value}}</span>
    </div>

<!--    <div class="bold f40 color272727 m1T m1L">协议与披露</div>-->
<!--    <div class="flexBox1 color656565 f33 m1L m1R m05B m05T">请花一些时间阅读以下协议和披露</div>-->
<!---->
<!--    <div class="flexBox1 m1L m1R m1T">-->
<!--        <a href="/agreement/agreement.pdf" target="_blank" class="color0547C1 m1R">IB Austrialia Pty ltd General Terms  andConditions </a>-->
<!--        <span>3300|4900</span>-->
<!--    </div>-->
<!--    <div class="f24 color656565">-->
<!--        <input class="m1L m15T"type="checkbox" checked/>&nbsp;我已阅读并同意以上协议-->
<!--    </div>-->
    <div class="flexBox1 m1L m1R m1T m2B">
        <div class="prevBtn borderCACACA color000 bgffffff cenetr radius20px f33 p05T p05B relative">
            上一步
            <a href="<?= Url::to(['regulatory', 'Customer_id' => $Customer_id])?>" class="fileInput"></a>
        </div>
        <div class="nextBtn f33 bgEF7E2E colorFFF cenetr  p05T p05B radius20px" @click="nextSubmit()">
            下一步
        </div>
    </div>
</div>

<script type="text/javascript">
    new Vue({
        el:"#vertify" ,
        data:{
            list1:[
                {'title':'名称','value':'<?= $data['candidata']['last_name']?> <?= $data['candidata']['first_name']?>'},
                {'title':'居住地址','value':'<?= $data['resident']['street']?>'},
                {'title':'电邮地址','value':'<?= $data['candidata']['email']?>'},
                {'title':'电话(手机)','value':'<?= $data['phone']['number']?>'},
                {'title':'婚姻状况','value':'<?= $data['candidata']['maritalStatus']?>'},
                {'title':'供养家属人数','value':'<?= $data['candidata']['numDependents']?>'},
                {'title':'出生日期','value':'<?= $data['candidata']['DOB']?>'},
                {'title':'国家/地区','value':'<?= $data['candidata']['countryOfBirth']?>'},
                {'title':'<?= $data['identity']['type']?>','value':'<?= $data['identity']['number']?>'},
                {'title':'税号','value':'<?= $data['tax']['TIN']?>'}
            ],
            list2:[
                {'title':'就业类型','value':'<?= $data['candidata']['employment_type']?>'},
                {'title':'年度净收入','value':'<?= $data['financial']['annual_net_income_value']?>'},
                {'title':'资产净值','value':'<?= $data['financial']['net_worth_value']?>'},
                {'title':'流动资产净值','value':'<?= $data['financial']['liquid_net_worth_value']?>'},
                {'title':'投资目标','value':'<?= $data['investname']?>'},
                {'title':'股票交易经验','value':('<?=$data['experience']['years_trading']?>'+'年, '
                                                +'<?=$data['experience']['trades_per_year']?>'+'次 / 年')},
                {'title':'','value':('<?=$data['experience']['knowledge_level']?>')}
            ],
            list3:<?=$data['wealth']?>
                // [{'title':'财富来源','value':'90%'},
                // {'title':'工作收入','value':'90%'}]
        },
        mounted:function(){

        },
        methods:{
            nextSubmit:function (){
                window.location.href = "/account/agreements?Customer_id="+<?= $Customer_id?>;
            },
        }
    });
</script>
