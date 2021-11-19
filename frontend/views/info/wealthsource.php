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
    .textclass{
        font-size: 16px;
        text-align: left;
        padding:5px;
        width: calc(100% - 2rem - 10px);
        /*color: #ADADAD;*/
    }

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
<div id="vertify">
    <div class="bold f40 color272727 m1T m1L p05B">财富来源</div>
    <div class="f24 color878787 m1L m1B">请填写财富来源并说明占比，法规要求我们收集该信息</div>
    <input type="hidden" value="<?php print_r($data)?>" />
    <div v-for='(item,index) in list2'>
        <div class="flexBox1 m1L m1R borderB m1B p05B">
            <div class="flexBox2 p05T p05B">
                <img src="../img/icon_25.png" style="width:1.46rem;height:1.46rem;" @click="chose2(item,index)"/>
                <span class="m05L">{{item.name}}</span>
            </div>
            <div class="borderAll flexBox1 radius10px">
                <div class="p05L p05R bold" @click="reduce(index)">-</div>
                <div class="borderL borderR p05L p05R">{{item.percent}}%</div>
                <div class="p05L p05R bold" @click="add(index)">+</div>
                <input type="hidden" :name="item.id" v-model="item.percent"  />
            </div>
        </div>
        <textarea v-if="item.id=='SOW-IND-Other'" name="othertext" rows="5" style="overflow: hidden;" class="borderAll radius10px m1L m1R w100_ textclass" placeholder="点此提供更详细信息">{{item.description}}</textarea>
        <div v-if="item.id=='SOW-IND-Other'" class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none" :class="othershow">其他来源需要填写说明</div>
    </div>

<!--    <textarea name="othertext" rows="5" style="overflow: hidden;" :class="on" class="borderAll radius10px m1L m1R w100_ text none" placeholder="点此提供更详细信息"></textarea>-->

    <div class="flexBox1 m1L borderB m1B p05B" v-for='(item,index) in list' @click="chose(item,index)">
        <div class="flexBox2 p05T p05B">
            <img src="../img/icon_26.png" style="width:1.46rem;height:1.46rem;"/>
            <span class="m05L">{{item.name}}</span>
        </div>
    </div>

    <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none" :class="percentshow">财富来源达到100%</div>

    <div class="flexBox1 m1L m1R m1T wBtnBox m2B">
        <div class="prevBtn borderCACACA color000 bgffffff cenetr radius20px f33 p05T p05B relative">
            上一步
            <a href="<?= Url::to(['employinfo', 'Customer_id' => $Customer_id])?>" class="fileInput"></a>
        </div>
        <div class="nextBtn f33 bgEF7E2E colorFFF cenetr  p05T p05B radius20px" @click="nextsubmit()">
            下一步
            <input type="submit" class="divHide" id="next">
        </div>
    </div>
</div>
<?php ActiveForm::end() ?>
<script type="text/javascript">
    //     [{'id':'ws1','name':'工作收入','percent':'10'},
    //     {'id':'ws2','name':'津贴 / 配偶收入','percent':'10'},
    //     {'id':'ws3','name':'残疾 / 离职补偿 / 失业金','percent':'10'},
    //     {'id':'ws4','name':'继承 / 礼物','percent':'10'},
    //     {'id':'ws5','name':'利息 / 股息收入','percent':'10'},
    //     {'id':'ws6','name':'市场交易利润','percent':'10'},
    //     {'id':'ws7','name':'养老金 / 政府退休福利','percent':'10'},
    //     {'id':'ws8','name':'房产','percent':'10'},
    //     {'id':'ws9','name':'其他','percent':'10'}]
    new Vue({
        el:"#vertify" ,
        data:{
            list:<?=$wealthsource?>,
            list2:<?=$wealthmodel?>,
            isShow:false,
            showmessage:false,
            otherwar:false,
        },
        computed:{
            on:function(){//textarea
                return this.isShow?'show':''
            },
            percentshow:function(){
                return this.showmessage?'show':''
            },
            othershow:function(){
                return this.otherwar?'show':''
            }
        },
        methods:{
            chose:function(item,index){
                if(item.name=='其他'){
                    this.isShow=true
                }else{
                    this.isShow=false
                }
                this.list2.push(item);
                this.list.splice(index,1);
            },
            chose2:function(item,index){
                // console.log(item.name)
                if(item.name=='其他'){
                    this.isShow=false;
                }
                this.list2.splice(index,1);
                item.percent = '10';
                this.list.push(item);
            },
            reduce:function(index){
                if(this.list2[index].percent<20){
                    return false
                }
                this.list2[index].percent=parseInt(this.list2[index].percent)-10
            },
            add:function(index){
                if(this.list2[index].percent>90){
                    return false
                }
                this.list2[index].percent=parseInt(this.list2[index].percent)+10
            },
            nextsubmit(){
                var total_percent = 0;
                var texttab = true;
                for(var i=0;i<this.list2.length;i++){
                    total_percent += parseInt(this.list2[i].percent);
                    if(this.list2[i].id=='SOW-IND-Other'){
                        var textarea = $("textarea[name=othertext]").val();
                        if(textarea.trim()=="" || textarea.trim()=="underfined"){
                            texttab = false;
                            break;
                        }
                    }
                }
                if(!texttab){
                    this.otherwar = true;
                }else{
                    this.otherwar = false;
                    if(total_percent < 100){
                        this.showmessage = true;
                    }else{
                        this.showmessage = false;
                        $('#next').trigger('click');
                    }
                }

            }
        }
    });
</script>
