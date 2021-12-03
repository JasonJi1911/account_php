<?php

use common\models\Identity;
use yii\helpers\Url;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\metronic\widgets\ActiveForm;
use common\models\Candidate;
use common\models\Phone;
use common\metronic\widgets\ActiveField;

$this->title = '财猫证券开户';
AppAsset::register($this);

$js = <<<JS
$(function(){
    $("#divNext").click(function (){
        $('#next').trigger('click');
    });
});
JS;

$this->registerJs($js);
?>
<style>
    .help-block{display: none;}
    .help-block_padding {
        padding-bottom: 0.5rem;
        padding-top: 0.5rem;
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
<!--<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>-->
<script type="text/javascript" src="/js/vue@2.js"></script>
<?php $form = ActiveForm::begin([
    'id' => 'contact-form',
    'enableClientValidation' => true,
//    'enableAjaxValidation' => true,
]) ?>
<div id="vertify">
    <div class="box">
        <div class="bold f40 color272727 m1T m1L p05B">个人信息</div>
        <div class="f24 color878787 m1L m1B">仅用于开户审核，隐私信息严格保密！</div>
        <div class="colorEF7E2E f33 bold bgF8F8F8 p1L p05T p05B flexBox2">
            <img src="/img/icon_2.png" style="width:1.5rem;"/>
            &nbsp;身份证明信息
        </div>
        <div class="m1L m1T p1B borderB color656565 flexBox1" @click="show('2')">
            <div class="flexBox2">
                <div class="w140">签发国家/地区 <span class="colorEF7E2E">*</span></div>
                <span class="color232323">{{choseData2}}</span>
                <?= $form->field($identity, 'issue_country')
                    ->textInput(['class'=>'none', ':value' => 'choseValue2'])
                    ->label(false)->error(false) ?>
            </div>
            <div class="sj m1R"></div>
        </div>
        <ul class="color303030 f33 none" :class="obj['2'].on" ref="select2">
            <li class="p05T p05B borderB p1L" v-for='item in list2' @click="chose(item,'2')">{{item.name}}</li>
        </ul>
        <?php if($identity->hasErrors('issue_country')):?>
            <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6"><?= $identity->getErrors('issue_country')[0] ?></div>
        <?php endif;?>

        <div class="m1L m1T p1B borderB color656565 flexBox1" @click="show('0')">
            <div class="flexBox2">
                <div class="w140">证件类型 <span class="colorEF7E2E">*</span></div>
                <span class="color232323">{{choseData0?choseData0:'请选择'}}</span>
                <?= $form->field($identity, 'type')
                    ->textInput(['class'=>'none', ':value' => 'choseValue0'])
                    ->label(false)->error(false) ?>
            </div>
            <div class="sj m1R"></div>
        </div>
        <ul class="color303030 f33 none" :class="obj['0'].on" ref="select0">
            <li class="p05T p05B borderB p1L" v-for='item in list0' @click="chose(item,'0')">{{item.name}}</li>
        </ul>
        <?php if($identity->hasErrors('type')):?>
            <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6"><?= $identity->getErrors('type')[0] ?></div>
        <?php endif;?>

        <div class="m1L m1T p1B borderB color656565 flexBox2">
            <div class="w140">证件号码 <span class="colorEF7E2E">*</span></div>
            <?= $form->field($identity, 'number')
                ->textInput(['class'=>'f16'])->label(false)->error(false) ?>
        </div>
        <?php if($identity->hasErrors('number')):?>
            <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6"><?= $identity->getErrors('number')[0]?></div>
        <?php endif;?>
        <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war0">证件号码格式不正确</div>

        <div class="m1L m1T p1B color656565 flexBox1 borderB" @click="show('1')">
            <div class="flexBox2">
                <div class="w140">签发州/省 <span class="colorEF7E2E">*</span></div>
                <span class="colorADADAD">{{choseData1?choseData1:' 请选择签发州/省'}}</span>
                <?= $form->field($identity, 'issue_state')
                    ->textInput(['class'=>'none', ':value' => 'choseValue1'])
                    ->label(false)->error(false) ?>
            </div>
            <div class="sj m1R"></div>
        </div>
        <ul class="color303030 f33 none" :class="obj['1'].on" ref="select1">
            <li class="p05T p05B borderB p1L" v-for='item in list1' @click="chose(item,'1')">{{item.name}}（{{item.des}}）</li>
        </ul>
        <?php if($identity->hasErrors('issue_state')):?>
            <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6"><?= $identity->getErrors('issue_state')[0] ?></div>
        <?php endif;?>

        <div class="m1L m1T p1B borderB color656565 flexBox2">
            <div class="w140">RTA号码</div>
            <?= $form->field($identity, 'RTA')
                ->textInput(['class'=>'f16'])->label(false)->error(false) ?>
        </div>
        <?php if($identity->hasErrors('RTA')):?>
            <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6"><?= $identity->getErrors('RTA')[0] ?></div>
        <?php endif;?>

        <div class="m1L m1T p1B borderB color656565 flexBox1">
            <div class="flexBox2">
                <div class="w140">证件到期 <span class="colorEF7E2E">*</span></div>
                <?= $form->field($identity, 'expiration')
                    ->textInput(['class'=>'sp-date f16', 'placeholder'=>'请选择日期', ':value' => 'choseDOB'])->label(false)
                    ->error(false) ?>
            </div>
            <div class="sj m1R"></div>
        </div>
        <?php if($identity->hasErrors('expiration')):?>
            <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6"><?= $identity->getErrors('expiration')[0] ?></div>
        <?php endif;?>

        <div class="flexBox1 m1L m1R m1T wBtnBox" :class="isFixed">
            <div class="prevBtn borderCACACA color000 bgffffff cenetr radius20px f33 p05T p05B relative">
                上一步
                <a href="<?= Url::to(['identity-card', 'Customer_id' => $Customer_id])?>" class="fileInput"></a></div>
            <div class="nextBtn f33 bgEF7E2E colorFFF cenetr  p05T p05B radius20px" @click="nextSubmit()">
                下一步
                <input type="submit" class="divHide" id="next">
            </div>
        </div>
    </div>
    <div class="mask none" :class="on"></div>
</div>
<?php ActiveForm::end() ?>
<script type="text/javascript" src="/js/jquery-1.11.0.js"></script>
<script type="text/javascript" src="/js/jquery.selector-px.js"></script>
<script type="text/javascript">
    new Vue({
        el:"#vertify" ,
        data:{
            on:'',
            list0:[
                {'name':'澳洲驾照(推荐)', 'value':'DriversLicense'},
                {'name':'澳洲photoID', 'value':'NationalCard'},
                {'name':'澳洲护照', 'value':'Passport'}
            ],
            list1:<?=$state?>,
            list2:[
                {'name':'澳大利亚', 'value':'AUS'},
                {'name':'美国', 'value':'USA'},
                {'name':'中国', 'value':'CHN'}
            ],
            choseData0:'澳洲驾照（推荐）',
            choseValue0: 'DriversLicense',
            choseData1:'',
            choseValue1: '',
            choseData2:'澳大利亚',
            choseValue2: 'AUS',
            choseDOB: '',
            activeFixed:true,
            obj:[
                {
                    on:'',
                    switch:false
                },
                {
                    on:'',
                    switch:false
                },
                {
                    on:'',
                    switch:false
                }
            ]
        },
        mounted:function(){
            let year = new Date().getFullYear();
            let month = this.time2str(new Date().getMonth()+1);
            let date = this.time2str(new Date().getDate());
            let hours = this.time2str(new Date().getHours());
            let mins = this.time2str(new Date().getMinutes());

            // 年月日 时分
            $.dateSelector({
                evEle: '.sp-date',
                title:'',//日期和时间
                year: year,
                month: month,
                day: date,
                hour: hours,
                minute: mins,
                startYear: year-100,
                endYear: year+100,
                timeBoo: false,  //是否显示时分this.time
                afterAction:  (d1, d2, d3, d4, d5)=>{
                    this['choseDOB'] = d1 + '-' + d2 + '-' + d3;// + '  ' + d4 + ':' + d5
                }
            });

            this.choseValue0 = '<?= $identity->type != null ? $identity->type : 'DriversLicense'?>';
            this.doChange(0);
            this.choseValue1 = '<?= $identity->issue_state != null ? $identity->issue_state : ''?>';
            this.doChange(1);
            this.choseValue2 = '<?= $identity->issue_country != null ? $identity->issue_country : 'AUS'?>';
            this.doChange(2);
            this.choseDOB= '<?= $identity->expiration != null ? $identity->expiration : ''?>'
        },
        computed:{
            isFixed:function(){
                return this.activeFixed?'fixed':''
            },
        },
        methods:{
            time2str(t){
                return t>9?t:'0'+t;
            },
            chose:function(data,index,isInit=false){
                this['choseData'+index]=data.name
                this['choseValue'+index]=data.value
                if (!isInit)
                {
                    this.obj[index].switch=!this.obj[index].switch
                    this.obj[index].switch?this.obj[index].on='show':this.obj[index].on=''
                    this.obj[index].switch?this.on='show':this.on=''
                }
            },
            show:function(index){
                this.obj[index].switch=!this.obj[index].switch
                this.obj[index].switch?this.obj[index].on='show':this.obj[index].on=''
                this.obj[index].switch?this.on='show':this.on=''
                var flag = false;
                for(var i=0;i<this.obj.length;i++){
                    if(this.obj[i].switch){
                        flag = true;
                        break;
                    }
                }
                this.activeFixed = !flag;
            },
            doChange(index)
            {
                var iniVal = this['choseValue' + index]
                var packJson = this['list' + index]
                for (var val in packJson) {
                    if (packJson[val].value == iniVal)
                    {

                        this.chose(packJson[val], index, true);
                        break;
                    }
                }
            },
            nextSubmit:function(){
                var reg =  /^.{0,64}$/;
                var num = $("#identity-number").val();
                if(this['choseValue0']=='DriversLicense' && !reg.test(num)){
                    $(".war0").show();
                }else{
                    $(".war0").hide();
                    $('#next').trigger('click');
                }
            }
        }
    });
</script>