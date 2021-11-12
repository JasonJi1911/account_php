<?php

use common\models\Identity;
use yii\helpers\Url;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\Candidate;
use common\models\Phone;

$this->title = '国家/地区-财猫证券开户';
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

<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<?php $form = ActiveForm::begin([
    'id' => 'contact-form',
    'enableClientValidation' => true,
//    'enableAjaxValidation' => true,
]) ?>
<div id="country">
    <div class="box">
        <div class="f40 color272727 m53-37 bold">国家 / 地区</div>
        <div class="m1L m1T p1B borderB color656565 flexBox1" @click="show('0')">
            <div class="flexBox2 f34">
                <div class="w140">国家 / 地区 <span class="colorEF7E2E">*</span></div>
                <span class="color232323">{{choseData0}}</span>
                <?= $form->field($candidate, 'citizenship')->textInput(['class'=>'none', ':value' => 'choseValue0'])->label(false) ?>
            </div>
            <div class="sj m1R"></div>
        </div>
        <ul class="color303030 f33 none" :class="obj['0'].on" ref="select0">
            <li class="p05T p05B borderB p1L" v-for='item in list0' @click="chose(item,'0')">{{item.name}}</li>
        </ul>

        <div class="m1L m1T p1B borderB color656565 flexBox1" @click="show('2')">
            <div class="flexBox2 f34">
                <div class="w140">出生地<span class="colorEF7E2E">*</span></div>
                <span class="color232323">{{choseData2}}</span>
                <?= $form->field($candidate, 'same_citizen')->textInput(['class'=>'none', ':value' => 'choseValue2'])->label(false) ?>
            </div>
            <div class="sj m1R"></div>
        </div>
        <ul class="color303030 f33 none" :class="obj['2'].on" ref="select2">
            <li class="p05T p05B borderB p1L" v-for='item in list2' @click="chose(item,'2')">{{item.name}}</li>
        </ul>

        <div class="none" :class="isShow">
            <div class="m1L m1T p1B borderB color656565 flexBox1" @click="show('3')">
                <div class="flexBox2 f34">
                    <div class="w140"></div>
                    <span class="color232323">{{choseData3}}</span>
                    <?= $form->field($candidate, 'countryOfBirth')->textInput(['class'=>'none', ':value' => 'choseValue3'])->label(false) ?>
                </div>
                <div class="sj m1R"></div>
            </div>
        </div>
        <ul class="color303030 f33 none" :class="obj['3'].on" ref="select3">
            <li class="p05T p05B borderB p1L" v-for='item in list3' @click="chose(item,'3')">{{item.name}}</li>
        </ul>

        <div class="m1L m1T p1B borderB color656565 flexBox1" @click="show('1')">
            <div class="flexBox2 f34">
                <div class="w140">证件类型 <span class="colorEF7E2E">*</span></div>
                <span class="color232323">{{choseData1}}</span>
                <?= $form->field($identity, 'type')->textInput(['class'=>'none', ':value' => 'choseValue1'])->label(false) ?>
            </div>
            <div class="sj m1R"></div>
        </div>
        <ul class="color303030 f33 none" :class="obj['1'].on" ref="select1">
            <li class="p05T p05B borderB p1L" v-for='item in list1' @click="chose(item,'1')">{{item.name}}</li>
        </ul>

        <input type="submit" class="divHide" id="next">
        <div class="f33 bgEF7E2E colorFFF cenetr m1L m1R p05T p05B radius20px fixed bottom w100_" id="divNext">
            下一步
        </div>
    </div>
    <div class="mask none" :class="on"></div>
</div>
<?php ActiveForm::end() ?>

<script type="text/javascript">
    var vm = new Vue({
        el:"#country" ,
        data:{
            on:'',
            list0:[
                {'name':'澳大利亚', 'value':'AUS'},
                {'name':'美国', 'value':'USA'},
                {'name':'中国', 'value':'CHN'}
            ],
            list1:[
                {'name':'澳洲驾照(推荐)', 'value':'DriversLicense'},
                {'name':'身份证', 'value':'NationalCard'},
                {'name':'护照', 'value':'Passport'}
            ],
            list2:[
                {'name':'与国家地区一致', 'value':'1'},
                {'name':'与国家地区不一致', 'value':'0'},
            ],
            list3:[
                {'name':'澳大利亚', 'value':'AUS'},
                {'name':'美国', 'value':'USA'},
                {'name':'中国', 'value':'CHN'}
            ],
            choseData0: '澳大利亚',
            choseValue0: 'AUS',
            choseData1: '澳洲驾照(推荐)',
            choseValue1: 'DriversLicense',
            choseData2: '与国家地区一致',
            choseValue2: '1',
            choseData3: '澳大利亚',
            choseValue3: 'AUS',
            active:false,
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
                },
                {
                    on:'',
                    switch:false
                }
            ]
        },
        watch:{
            choseValue0:{
                deep: true,
                handler: function (newVal,oldVal){
                    console.log('newValue', newVal);
                    console.log('oldValue', oldVal);
                }
            }
        },
        mounted: function () {
            console.log(324);
            this.choseValue0 = '<?= $candidate->citizenship != null ? $candidate->citizenship : 'AUS'?>';
            this.doChange(0);
            this.choseValue1 = '<?= $identity->type != null ? $identity->type : 'DriversLicense'?>';
            this.doChange(1);
            this.choseValue2 = '<?= $candidate->same_citizen ?>';
            this.doChange(2);
            this.choseValue3 = '<?= $candidate->countryOfBirth != null ? $candidate->countryOfBirth : 'AUS'?>';
            this.doChange(3);
        },
        computed:{
            isShow:function(){
                return this.active?'show':''
            }
        },
        methods:{
            chose:function(data,index,isInit=false){
                if(data.name=='与国家地区不一致'){
                    this.active=true
                }else if(data.name=='与国家地区一致') {
                    this.active=false
                    this['choseData3']=this['choseData0']
                    this['choseValue3']=this['choseValue0']
                }

                if(index == 0 && this['choseData2'] == '与国家地区一致')
                {
                    this['choseData3']=data.name
                    this['choseValue3']=data.value
                }
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
            }
        },
    });
</script>