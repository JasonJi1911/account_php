<?php
use frontend\assets\AppAsset;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = '财猫证券开户';
AppAsset::register($this);

?>
<!--<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>-->
<script type="text/javascript" src="/js/vue@2.js"></script>
<?php $form = ActiveForm::begin([
    'id' => 'contact-form',
    'enableClientValidation' => false,
]) ?>
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
<div id="vertify">
    <div class="box">
        <div class="bold f40 color272727 m53-37 p05B">账户信息</div>
        <div class="m1L m1T p1B borderB color656565 flexBox1" @click="show('0')">
            <div class="flexBox2">
                <div class="w140">账户类型<span class="colorEF7E2E">*</span></div>
                <span class="color232323">{{choseData0?choseData0:'请选择'}}</span>
            </div>
            <div class="sj m1R"></div>
        </div>
        <ul class="color303030 f33 none" :class="obj['0'].on" ref="select0">
            <li class="p05T p05B borderB p1L" v-for='item in list0' @click="chose(item,'0')">{{item.name}}</li>
        </ul>
        <?= $form->field($account, 'AccountType')->textInput(['class'=>'none', ':value' => 'choseId0'])->label(false) ?>
        <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war0"></div>

        <div class="m1L m1T p1B borderB color656565 flexBox1" @click="show('1')">
            <div class="flexBox2">
                <div class="w140">基础货币<span class="colorEF7E2E">*</span></div>
                <span class="color232323">{{choseData1?choseData1:'请选择'}}</span>
            </div>
            <div class="sj m1R"></div>
        </div>
        <ul class="color303030 f33 none" :class="obj['1'].on" ref="select1">
            <li class="p05T p05B borderB p1L" v-for='item in list1' @click="chose(item,'1')">{{item.name}}</li>
        </ul>
        <?= $form->field($account, 'base_currency')->textInput(['class'=>'none', ':value' => 'choseId1'])->label(false) ?>
        <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war1"></div>

        <div class="flexBox1 m1L m1R m1T fixed wBtnBox">
            <div class="prevBtn borderCACACA color000 bgffffff cenetr radius20px f33 p05T p05B relative">
                上一步
                <a href="<?= Url::to(['uploadproof', 'Customer_id' => $Customer_id])?>" class="fileInput"></a>
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
<script type="text/javascript">
    new Vue({
        el:"#vertify" ,
        data:{
            on:'',
            list0:<?=$accountType?>,
            list1:<?=$base_currency?>,
            choseData0:'<?=$data['AccountType']?>',
            choseData1:'<?=$data['base_currency']?>',
            choseId0:'<?=$account['AccountType']?>',
            choseId1:'<?=$account['base_currency']?>',
            obj:[
                {on:'',switch:false},{on:'',switch:false}
            ]
        },
        mounted:function(){

        },
        methods:{
            chose:function(data,index){
                this['choseData'+index]=data.name;
                this['choseId'+index]=data.value;
                this.show(index);
                // this.obj[index].switch=!this.obj[index].switch
                // this.obj[index].switch?this.obj[index].on='show':this.obj[index].on=''
                // this.obj[index].switch?this.on='show':this.on=''
            },
            show:function(index){
                this.obj[index].switch=!this.obj[index].switch
                this.obj[index].switch?this.obj[index].on='show':this.obj[index].on=''
                this.obj[index].switch?this.on='show':this.on=''
            },
            valimessage:function(index,title){
                var value = this['choseId'+index];
                if(value.trim()==""){
                    $(".war"+index).text(title+"不能为空");
                    $(".war"+index).show();
                    return false;
                }else{
                    $(".war"+index).hide();
                    return true;
                }
            },
            nextsubmit:function(){
                if(this.valimessage('0','账户类型') && this.valimessage('1','基础货币')){
                    $('#next').trigger('click');
                }
            }
        }
    });
</script>
