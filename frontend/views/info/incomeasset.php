<?php
use frontend\assets\AppAsset;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = '财猫证券开户';
AppAsset::register($this);

?>
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
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
        <div class="bold f40 color272727 m53-37 p05B">收入和资产总值</div>
        <div class="m1L m1T p1B borderB color656565 flexBox1" @click="show('0')">
            <div class="flexBox2">
                <div class="w140">年度净收入<span class="colorEF7E2E">*</span></div>
                <span class="colorADADAD">{{choseData0?choseData0:list0[4].name}}</span>
            </div>
            <div class="sj m1R"></div>
        </div>
        <ul class="color303030 f33 none" :class="obj['0'].on" ref="select0">
            <li class="p05T p05B borderB p1L" v-for='item in list0' @click="chose(item,'0')">{{item.name}}</li>
        </ul>
        <?= $form->field($financial, 'annual_net_income')->textInput(['class'=>'none', ':value' => 'choseId0'])->label(false) ?>
        <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war0"></div>

        <div class="m1L m1T p1B borderB color656565 flexBox1" @click="show('1')">
            <div class="flexBox2">
                <div class="w140">资产净值<span class="colorEF7E2E">*</span></div>
                <span class="colorADADAD">{{choseData1?choseData1:list1[4].name}}</span>
            </div>
            <div class="sj m1R"></div>
        </div>
        <ul class="color303030 f33 none" :class="obj['1'].on" ref="select1">
            <li class="p05T p05B borderB p1L" v-for='item in list1' @click="chose(item,'1')">{{item.name}}</li>
        </ul>
        <?= $form->field($financial, 'net_worth')->textInput(['class'=>'none', ':value' => 'choseId1'])->label(false) ?>
        <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war1"></div>

        <div class="m1L m1T p1B borderB color656565 flexBox1" @click="show('2')">
            <div class="flexBox2">
                <div class="w140">流动资产净值<span class="colorEF7E2E">*</span></div>
                <span class="colorADADAD">{{choseData2?choseData2:list2[4].name}}</span>
            </div>
            <div class="sj m1R"></div>
        </div>
        <ul class="color303030 f33 none" :class="obj['2'].on" ref="select2">
            <li class="p05T p05B borderB p1L" v-for='item in list2' @click="chose(item,'2')">{{item.name}}</li>
        </ul>
        <?= $form->field($financial, 'liquid_net_worth')->textInput(['class'=>'none', ':value' => 'choseId2'])->label(false) ?>
        <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war2"></div>

        <div class="flexBox1 m1L m1R m1T wBtnBox" :class="showfixed">
            <div class="prevBtn borderCACACA color000 bgffffff cenetr radius20px f33 p05T p05B relative">
                上一步
                <a href="<?= Url::to(['wealthsource', 'Customer_id' => $Customer_id])?>" class="fileInput"></a>
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
            list0:<?=$annual_net_income?>,
            list1:<?=$net_worth?>,
            list2:<?=$liquid_net_worth?>,
            choseData0:'<?=$data['annual_net_income']?>',
            choseData1:'<?=$data['net_worth']?>',
            choseData2:'<?=$data['liquid_net_worth']?>',
            choseId0:'<?=$financial['annual_net_income']==""? 4 : $financial['annual_net_income']?>',
            choseId1:'<?=$financial['net_worth']==""? 4 : $financial['net_worth']?>',
            choseId2:'<?=$financial['liquid_net_worth']==""? 4 : $financial['liquid_net_worth']?>',
            activeFixed:true,
            obj:[
                {on:'',switch:false},{on:'',switch:false},{on:'',switch:false}
            ]
        },
        mounted:function(){

        },
        computed:{
            showfixed:function(){//就业状况
                return this.activeFixed?'fixed':''
            },
        },
        methods:{
            chose:function(data,index){
                this['choseData'+index]=data.name
                this['choseId'+index]=data.value
                this.show(index);
            },
            show:function(index){
                this.obj[index].switch=!this.obj[index].switch;
                this.obj[index].switch?this.obj[index].on='show':this.obj[index].on='';
                this.obj[index].switch?this.on='show':this.on='';
                (this.obj[0].switch || this.obj[1].switch || this.obj[2].switch)?this.activeFixed=false:this.activeFixed=true;
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
            getnumber:function(data,index){
                var n = 0;
                if(data.indexOf("<")>=0){
                    n = parseInt(data.replace("<",""));
                }else if(data.indexOf(">")>=0){
                    n = parseInt(data.replace(">",""));
                }else{
                    n = parseInt((data.split("-"))[index]);
                }
                return n;
            },
            nextsubmit:function(){
                if(this.valimessage('0','年度净收入') && this.valimessage('1','资产净值') && this.valimessage('2','流动资产净值')){
                    var d0 = this.getnumber(this['choseData0'],1);
                    var d1 = this.getnumber(this['choseData1'],0);
                    var d2 = this.getnumber(this['choseData2'],1);
                    if(d1<d2){//d1<d0 &&
                        $(".war2").text("资产净值须大于流动资产净值");
                        $(".war2").show();
                    }else{
                        $(".war2").hide();
                        $('#next').trigger('click');
                    }
                }
            }
        }
    });
</script>
