<?php
use frontend\assets\AppAsset;
//use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\metronic\widgets\ActiveForm;
use common\metronic\widgets\ActiveField;

$this->title = '规管信息-财猫证券开户';
AppAsset::register($this);

?>
<style>
    .help-block{display: none;}
    input::-webkit-input-placeholder{
        color: #656565;
        font-size: 1.06rem;
    }
    .input1::-webkit-input-placeholder{
        color: #ADADAD;
        font-size: 1.06rem;
    }

    .height-100Per{
        /*height: 100%;*/
    }

    .dropDown{
        background: #EF7E2E;
        color: white;
        margin-bottom: 50px;
        position: relative;
        z-index: 100;
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
<!--<link rel="stylesheet" type="text/css" href="/css/label.css" />-->
<!--<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>-->
<script type="text/javascript" src="/js/vue@2.js"></script>
<?php $form = ActiveForm::begin([
    'id' => 'contact-form',
    'enableClientValidation' => false,
]) ?>
<style>
    p{
        color:#303030;
        font-size: 1rem;
        margin-top: 1rem;
        margin-left: 1rem;
        margin-right: 1rem;
    }
    input[type='radio'] {
        position: relative;
        cursor: pointer;
        width: 20px;
        height: 20px; ;
        font-size: 12px;
        vertical-align: middle;
        margin-top: -2px;
        margin-bottom: 1px
    }
    input[type='radio']:checked::after {
        position: absolute;
        top: 0;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 20px;
        height: 20px;
        content: '';
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        background: url(../img/radiochecked.png) no-repeat;
        background-size: 100% 100%;
        background-color: #fff;
        border-radius: 2px;
    }
    label{
        display:block;
        text-align: center;
        height: 40px;
        line-height: 40px;
        margin:0 auto;
    }

    .labeldiv{
        width:48%;
        display: inline-block;
    }
</style>
<div id="vertify">
    <div class="bold f40 color272727 m1T m1L p05B">规管信息承诺协议</div>
    <div>
        <p>本人承诺：</p>
        <p>1.本人不是法定的美国居民、绿卡持有者、美国税收居民或SSN号码持有者；；</p>
        <p>2.本人及亲属无任职上市公司或交易所金融产品之发行人/承销商的董事、高级雇员或官员；</p>
        <p>3.本人及亲属无任意国家的高级政府官员；</p>
        <p>4.本人及亲属无澳大利亚或非澳大利亚领事馆的高级外交人员、大使、或高级专员；</p>
        <p>5.本人及亲属无任意国家武装部队的高级别人士；</p>
        <p>6.本人及亲属无任意国家国有企业的高级管理人员（CEO、CFO或同等职位管理人员）；</p>
        <p>7.本人及亲属无人受雇于任何经纪交易商、投资顾问、期货佣金商、对冲基金、交易所或其他金融服务公司（即"金融公司"）、或在该等机构进行过登记；</p>
    </div>
    <div class="m1T m1L m1R">
        <div class="relative labeldiv" >
            <label><input type="radio" name="regulatory"  value="0" v-model="checked0" />同意</label>
        </div>
        <div class="relative labeldiv" >
            <label ><input type="radio"  name="regulatory" value="1" v-model="checked0"/>不同意</label>
        </div>
    </div>
    <?= $form->field($regulatory, 'controller')->textInput(['class'=>"none", ':value' =>'checked0'])->label(false) ?>
    <?= $form->field($regulatory, 'political')->textInput(['class'=>"none", ':value' =>'checked0'])->label(false) ?>
<!--    --><?//= $form->field($regulatory, 'affiliation')->textInput(['class'=>"none", ':value' =>'checked0'])->label(false) ?>
    <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war0">请选择同意规管信息承诺协议</div>
<!--    <div class="flexBox1  m1L m1R m1T p1B">        -->
<!--        <div class="color303030 f33 m1R">-->
<!--            账户持有人或其直系亲属是否为上市-->
<!--            公司或交易所金融产品之发行人｜承-->
<!--            销商的董事、高级雇员或官员？-->
<!--        </div>-->
<!--        <div>-->
<!--            <input id="switch0" type="checkbox" @click="getSwitch('0',$event)">-->
<!--            --><?//= $form->field($regulatory, 'controller')->MySwitch(['id'=>"switch0", '@click' => 'getSwitch(0,$event)', 'label'=>false, ':value' =>'switch0'])->label(false) ?>
<!--        </div>-->
<!--    </div>-->
<!--    <div class="none" :class="isShow1">-->
<!--        <div class="flexBox2 m1L m1R m05T borderB p05B">-->
<!--            <span class="m1R f34 color656565">公司代码</span>-->
<!--            --><?//= $form->field($regulatory, 'exchange_code')
//                ->textInput(['placeholder' => '代码', 'class'=>'show input1 height-100Per'])
//                ->label(false) ?>
<!--        </div>-->
<!--        --><?php //if($regulatory->hasErrors('exchange_code')):?>
<!--            <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6">--><?//= $regulatory->getErrors('exchange_code')[0] ?><!--</div>-->
<!--        --><?php //endif;?>
<!--    </div>-->
<!--    <div class="flexBox1  m1L m1R m1T p1B">-->
<!--        <div class="color303030 m1R">-->
<!--            账户持有人或账户持有人的直系亲属-->
<!--            是否符合以下描述（1）为任意国家-->
<!--            的高级政府官员：（2）澳大利亚或-->
<!--            非澳大利亚领事馆的高级外交人员、-->
<!--            大使或高级专员：（3）任意国家武-->
<!--            装部队的高级别人士：（4）任意国-->
<!--            家国有企业的高级管理人员（ceo-->
<!--            CFO或同等职位管理人员）？-->
<!--        </div>-->
<!--        <div>-->
<!--            <input id="switch1" type="checkbox" @click="getSwitch('1',$event)">-->
<!--            --><?//= $form->field($regulatory, 'political')->MySwitch(['id'=>"switch1", '@click' => 'getSwitch(1,$event)', 'label'=>false, ':value' =>'switch1'])->label(false) ?>
<!--            <label for="switch1"></label>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="none color656565 f30" :class="isShow2">-->
<!--        <div class="flexBox2 m1L m1R m05T borderB p05B">-->
<!--            <span class="m1R f34">姓名</span>-->
<!--            --><?//= $form->field($regulatory, 'political_title')
//                ->textInput(['placeholder' => '', 'class'=>'show height-100Per'])
//                ->label(false) ?>
<!--        </div>-->
<!--        --><?php //if($regulatory->hasErrors('political_title')):?>
<!--            <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6">--><?//= $regulatory->getErrors('political_title')[0] ?><!--</div>-->
<!--        --><?php //endif;?>
<!--        <div class="flexBox2 m1L m1R m05T borderB p05B">-->
<!--            <span class="m1R f34">职位 / 职务</span>-->
<!--            --><?//= $form->field($regulatory, 'political_person_name')
//                ->textInput(['placeholder' => '', 'class'=>'show height-100Per'])
//                ->label(false) ?>
<!--        </div>-->
<!--        --><?php //if($regulatory->hasErrors('political_person_name')):?>
<!--            <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6">--><?//= $regulatory->getErrors('political_person_name')[0] ?><!--</div>-->
<!--        --><?php //endif;?>
<!--        <div class="flexBox2 m1L m1R m05T borderB p05B">-->
<!--            <span class="m1R f34">组织</span>-->
<!--            --><?//= $form->field($regulatory, 'political_organization')
//                ->textInput(['placeholder' => '', 'class'=>'show height-100Per'])
//                ->label(false) ?>
<!--        </div>-->
<!--        --><?php //if($regulatory->hasErrors('political_organization')):?>
<!--            <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6">--><?//= $regulatory->getErrors('political_organization')[0] ?><!--</div>-->
<!--        --><?php //endif;?>
<!---->
<!--        <div class="m1L m1T p1B borderB color656565 flexBox1" @click="show('1')">-->
<!--            <div class="flexBox2">-->
<!--                <div class="w140 f30">国家 / 地区</div>-->
<!--                <span class="colorADADAD">{{choseData1?choseData1:'请选择'}}</span>-->
<!--                --><?//= $form->field($regulatory, 'political_country')
//                    ->textInput(['class'=>'none', ':value' => 'choseValue1'])
//                    ->label(false)->error(false) ?>
<!--            </div>-->
<!--            <div class="sj m1R"></div>-->
<!--        </div>-->
<!--        <ul class="color303030 f33 none" :class="obj['1'].on" ref="select1">-->
<!--            <li class="p05T p05B borderB p1L" v-for='item in list1' @click="chose(item,'1')">{{item.name}}</li>-->
<!--        </ul>-->
<!--        --><?php //if($regulatory->hasErrors('political_country')):?>
<!--            <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6">--><?//= $regulatory->getErrors('political_country')[0] ?><!--</div>-->
<!--        --><?php //endif;?>
<!--    </div>-->
<!--    <div class="flexBox1  m1L m1R m1T p1B">-->
<!--        <div class="color303030 f33 m1R">-->
<!--            您或您的任何直系亲属是否受雇于任-->
<!--            何经济交易商、投资顾问、期货佣金-->
<!--            商、对冲基金、交易所或其他金融服-->
<!--            务公司（即“金融公司”）、或在该等-->
<!--            机构进行过登记？-->
<!--        </div>-->
<!--        <div>-->
<!--            <input id="switch2" type="checkbox" @click="getSwitch('2',$event)">-->
<!--            <label for="switch2"></label>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="none color656565 f30" :class="isShow3">-->
<!--        <div class="m1L m1T p1B borderB color656565 flexBox1" @click="show('0')">-->
<!--            <div class="flexBox2">-->
<!--                <div class="w140 f30">谁受金融公司雇佣</div>-->
<!--                <span class="colorADADAD">{{choseData0?choseData0:'请选择'}}</span>-->
<!--            </div>-->
<!--            <div class="sj m1R"></div>-->
<!--        </div>-->
<!--        <ul class="color303030 f33 none" :class="obj['0'].on" ref="select0">-->
<!--            <li class="p05T p05B borderB p1L" v-for='item in list0' @click="chose(item,'0')">{{item}}</li>-->
<!--        </ul>-->
<!--        <div class="flexBox1  m1L m1R m1T p1B borderB">-->
<!--            <div class="color878787 f27 m1R">-->
<!--                需要重复发送声明和确定信息到您公司的合 规部门吗？-->
<!--            </div>-->
<!--            <div>-->
<!--                <input checked id="switch3" type="checkbox" @click="getSwitch('3',$event)">-->
<!--                <label for="switch3"></label>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div :class="isShow4">-->
<!--            <div class="m1L m1T p1B borderB color656565 flexBox2">-->
<!--                <div class="w140 f30">雇佣单位</div>-->
<!--                <input placeholder="请填写完整的公司名称" value="" class="show input1"/>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <div class="flexBox1 m1L m1R m1T  wBtnBox" style="z-index: 10"><!-- fixed -->
        <div class="prevBtn borderCACACA color000 bgffffff cenetr radius20px f33 p05T p05B relative">
            上一步
            <a href="<?= Url::to(['info/permissions', 'Customer_id' => $Customer_id])?>" class="fileInput"></a>
        </div>
        <div class="nextBtn f33 bgEF7E2E colorFFF cenetr  p05T p05B radius20px" @click="nextSubmit()">
            下一步
            <input type="submit" class="divHide" id="next">
        </div>
    </div>
</div>
<?php ActiveForm::end() ?>

<script type="text/javascript">
    new Vue({
        el:"#vertify" ,
        data:{
            checked0:0,
            on:'',
            active:[false,false,false,true],
            activeFixed:true,
            list0:[
                {'name':'配偶', 'value':'Spouse'},
                {'name':'父母', 'value':'Parent'},
                {'name':'子女', 'value':'Child'},
                {'name':'其他', 'value':'Other'},
            ],
            list1:[
                {'name':'澳大利亚', 'value':'AUS'},
                {'name':'美国', 'value':'USA'},
                {'name':'中国', 'value':'CHN'}
            ],
            choseData0:'',
            choseData1:'澳大利亚',
            choseValue1: 'AUS',
            switch0: '<?= $regulatory->controller != null ? $regulatory->controller : '0'?>',
            switch1: '<?= $regulatory->political != null ? $regulatory->political : '0'?>',
            obj:[
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
            this.active['0'] = <?= $regulatory->controller != null && $regulatory->controller == '1' ? 'true' : 'false'?>;
            this.active['1'] = <?= $regulatory->political != null && $regulatory->political == '1' ? 'true' : 'false'?>;
            this.$set(this.active, 0, this.active[0])
            this.$set(this.active, 1, this.active[1])
            this.activeFixed = (this.active['1']?false:true)
        },
        computed:{
            isShow1:function(){
                return this.active['0']?'show':''
            },
            isShow2:function(){
                return this.active['1']?'show':''
            },
            isShow3:function(){
                return this.active['2']?'show':''
            },
            isShow4:function(){
                return this.active['3']?'show':'none'
            },
            isFixed:function(){
                return this.activeFixed?'fixed':''
            },

        },
        methods:{
            chose:function(data,index){
                this['choseData'+index]=data.name
                this['choseValue'+index]=data.value
                this.obj[index].switch=!this.obj[index].switch
                this.obj[index].switch?this.obj[index].on='show':this.obj[index].on=''
                this.obj[index].switch?this.on='show':this.on=''
            },
            show:function(index){
                this.obj[index].switch=!this.obj[index].switch
                this.obj[index].switch?this.obj[index].on='show':this.obj[index].on=''
                this.obj[index].switch?this.on='show':this.on=''
            },
            getSwitch:function(index,ev){
                this.active[index]=!this.active[index]
                this.$set(this.active, index, this.active[index])
                if (this['switch'+index]=='0')
                    this['switch'+index]='1'
                else
                    this['switch'+index]='0'
            },
            nextSubmit:function(){
                var value = this['checked0'];
                if(value==0){
                    $('.war0').hide();
                    $('#next').trigger('click');
                }else{
                    $('.war0').show();
                }

            }
        }
    });
</script>


