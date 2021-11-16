<?php
use frontend\assets\AppAsset;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = '财猫证券开户';
AppAsset::register($this);

?>
<?php $form = ActiveForm::begin([
    'id' => 'contact-form',
    'enableClientValidation' => true,
//    'enableAjaxValidation' => true,
]) ?>
<style>
    input{font-size: 16px;}
    .heightAuto{height:auto;}
    .help-block{
        color: #ff0000;
        height: 1px;
        line-height: 1px;
        margin-top: -10px;
        padding-bottom: 5px;
    }
    .help-nonediv{
        margin-left: 1rem;
        padding-left: 140px;
    }
    .fileInput{
        position: absolute;
        top: 0;
        left: 0;
        width: 30%;
        height: 100%;
        margin: 0;
        font-size: 23px;
        cursor: pointer;
        filter: alpha(opacity=0);
        opacity: 0;
        direction: ltr;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<div id="vertify">
    <div class="box">
        <div class="bold f40 color272727 m1T m1L p05B">个人信息</div>
        <div class="f24 color878787 m1L m1B">仅用于开户审核，隐私信息严格保密！</div>
        <div class="colorEF7E2E bgF8F8F8 p1L p05T p05B flexBox5 bold f33">
            <img src="../img/icon_18.png" style="width:1.5rem;"/>
            &nbsp;个人信息
        </div>
        <div class="m1L m1T p1B borderB color656565 flexBox2">
            <div class="w140">出生日期<span class="colorEF7E2E">*</span></div>
<!--            <input placeholder="请选择日期" value="2021-23-23" />-->
            <?= $form->field($candidate, 'DOB')->textInput(['class'=>'sp-date', 'placeholder'=>'请选择日期', ':value' => 'choseDOB'])->label(false) ?>
        </div>

        <div class="m1L m1T p1B borderB color656565 flexBox1 heightAuto" @click="show('0')">
            <div class="flexBox2">
                <div class="w140">婚姻状况 <span class="colorEF7E2E">*</span></div>
                <span class="colorADADAD">{{choseData0?choseData0:'请选择'}}</span>
            </div>
            <div class="sj m1R"></div>
        </div>
        <ul class="color303030 f33 none" :class="obj['0'].on" ref="select0">
            <li class="p05T p05B borderB p1L" v-for='item in list0' @click="chose(item,'0')">{{item}}</li>
        </ul>
        <div class="help-nonediv">
            <?= $form->field($candidate, 'maritalStatus')->textInput(['class'=>'none', ':value' => 'choseData0','style'=>'margin-left:140px;'])->label(false) ?>
        </div>

        <div class="m1L borderB color656565 flexBox1 inputH heightAuto">
            <div class="flexBox2">
                <div class="w140">家庭成员数量<span class="colorEF7E2E">*</span></div>
<!--                <input class="inputW" placeholder='请输入家庭成员数量' value=""/>-->
                <?= $form->field($candidate, 'numDependents')->textInput(['placeholder'=>'请输入家庭成员数量', 'class' => 'inputW', 'pattern'=>"[0-9]*",'value'=>$candidate['numDependents']])->label(false) ?>
            </div>
        </div>

        <div class="m1L m1T p1B borderB color656565 flexBox1" @click="show('2')">
            <div class="flexBox2">
                <div class="w140">纳税国家<span class="colorEF7E2E">*</span></div>
                <span class="color232323">{{choseData2}}</span>
            </div>
            <div class="sj m1R"></div>
        </div>
        <ul class="color303030 f33 none" :class="obj['2'].on" ref="select2">
            <li class="p05T p05B borderB p1L" v-for='item in list2' @click="chose(item,'2')">{{item.name}}</li>
        </ul>
        <?= $form->field($tax, 'country')->textInput(['class'=>'none', ':value' => 'choseId2'])->label(false) ?>

        <div class="m1L borderB color656565 flexBox2 inputH heightAuto">
            <div class="w140">税号（TEN）<span class="colorEF7E2E">*</span></div>
<!--            <input class="inputW" placeholder="请输入税号（TEN）" value="" />-->
            <?= $form->field($tax, 'TIN')->textInput(['placeholder'=>'请输入税号（TEN）', 'class' => 'inputW'])->label(false) ?>
        </div>

        <div class="flexBox1 m1L m1R m1T fixed wBtnBox">
            <div class="prevBtn borderCACACA color000 bgffffff cenetr radius20px f33 p05T p05B">
                上一步
                <a href="<?= Url::to(['contactinfo', 'Customer_id' => $Customer_id])?>" class="fileInput"></a>
            </div>
            <div class="nextBtn f33 bgEF7E2E colorFFF cenetr  p05T p05B radius20px" @click="nextsubmit()">
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
            list0:['未婚-S','已婚-M','离异-D','丧偶-W','同居-C'],
            list2:[{'name':'澳大利亚', 'value':'AUS'},{'name':'美国', 'value':'USA'},{'name':'中国', 'value':'CHN'}],
            choseData0:'<?=($candidate['maritalStatus']!='' ? $candidate['maritalStatus'] : '')?>',
            choseData2:'<?=$tax['country']=='USA' ? '美国' : ($tax['country']=='CHN' ? '中国' : '澳大利亚')?>',
            choseId2:'<?=$tax['country']!='' ? $tax['country'] : 'AUS'?>',
            choseDOB:'<?=$candidate['DOB']!='' ? $candidate['DOB'] : date('Y-m-d',time())?>',
            obj:[{on:'',switch:false},{on:'',switch:false},{on:'',switch:false}]
        },
        props: {
            height: {
                type: String,
            default: '.26rem',
            },
            width: {
                type: String,
            default: '34',
            },
            time: {
                type: Boolean,
            default: true,
            },
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
                endYear: year,
                timeBoo: false,  //是否显示时分this.time
                afterAction:  (d1, d2, d3, d4, d5)=>{
                    this['choseDOB'] = d1 + '-' + d2 + '-' + d3;// + '  ' + d4 + ':' + d5
                }
            });
        },
        methods:{
            time2str(t){
                return t>9?t:'0'+t;
            },
            chose:function(data,index){
                if(index=='0'){
                    this['choseData0']=data
                }else if(index=='2'){
                    this['choseData2']=data.name
                    this['choseId2']=data.value
                }
                this.obj[index].switch=!this.obj[index].switch
                this.obj[index].switch?this.obj[index].on='show':this.obj[index].on=''
                this.obj[index].switch?this.on='show':this.on=''
            },
            show:function(index){
                this.obj[index].switch=!this.obj[index].switch
                this.obj[index].switch?this.obj[index].on='show':this.obj[index].on=''
                this.obj[index].switch?this.on='show':this.on=''
            },
            nextsubmit:function(){
                $('#next').trigger('click');
            }
        }
    });
</script>
