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
    .input-width{width:calc(100% - 215px - 1rem);text-align:center;}
    .w-90{width:90px;padding-left: 5px;}
</style>
<div id="vertify">
    <div class="box">
        <div class="bold f40 color272727 m1T m1L p05B">投资经验</div>
        <div class="m1L m1T p1B borderB color656565 flexBox1" @click="show('0')">
            <div class="flexBox2">
                <div class="w160">是否开通股票交易<span class="colorEF7E2E">*</span></div>
                <span class="color232323">{{choseData0}}</span>
            </div>
            <div class="sj m1R"></div>
        </div>
        <ul class="color303030 f33 none" :class="obj['0'].on" ref="select0">
            <li class="p05T p05B borderB p1L" v-for='item in list0' @click="chose(item,'0')">{{item}}</li>
        </ul>
        <input type="hidden" :value="choseId0" class="valimessage0" name="asset_class0" />
        <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war0"></div>

        <div class="m1L m1T p1B borderB color656565 flexBox2">
            <div class="w160">股票交易年限<span class="colorEF7E2E">*</span></div>
            <input value="<?=$data['STK']['years_trading']?>" class="input-width show valimessage1" placeholder = "请输入年限" name="year0" @blur="valimessage('1','请输入股票交易年限')" />
            <div class="w-90 m1R">年交易经验</div>
        </div>
        <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war1"></div>

        <div class="m1L m1T p1B borderB color656565 flexBox2">
            <div class="w160">股票年交易笔数<span class="colorEF7E2E">*</span></div>
            <input value="<?=$data['STK']['trades_per_year']?>" class="input-width show valimessage2" placeholder = "请输入笔数" name="trades0" @blur="valimessage('2','请输入股票年交易笔数')" />
            <div class="w-90 m1R">笔交易｜年</div>
        </div>
        <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war2"></div>

        <div class="m1L m1T p1B borderB color656565 flexBox1" @click="show('1')">
            <div class="flexBox2">
                <div class="w160">股票知识水平<span class="colorEF7E2E">*</span></div>
                <span class="color232323">{{choseData1}}</span>
            </div>
            <div class="sj m1R"></div>
        </div>
        <ul class="color303030 f33 none" :class="obj['1'].on" ref="select1">
            <li class="p05T p05B borderB p1L" v-for='item in list1' @click="chose(item,'1')">{{item.name}}</li>
        </ul>
        <input type="hidden" :value="choseId1" class="valimessage3" name="level0" />
        <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war3"></div>





        <div class="m1L m1T p1B borderB color656565 flexBox1" @click="show('2')">
            <div class="flexBox2">
                <div class="w160">是否开通换汇交易<span class="colorEF7E2E">*</span></div>
                <span class="color232323">{{choseData2}}</span>
            </div>
            <div class="sj m1R"></div>
        </div>
        <ul class="color303030 f33 none" :class="obj['2'].on" ref="select2">
            <li class="p05T p05B borderB p1L" v-for='item in list2' @click="chose(item,'2')">{{item}}</li>
        </ul>
        <input type="hidden" :value="choseId2" class="valimessage4" name="asset_class1" />
        <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war4"></div>

        <div class="m1L m1T p1B borderB color656565 flexBox2">
            <div class="w160">换汇交易年限<span class="colorEF7E2E">*</span></div>
            <input value="<?=$data['CASH']['years_trading']?>" class="input-width show valimessage5" placeholder = "请输入年限" name="year1" />
            <div class="w-90 m1R">年交易经验</div>
        </div>
        <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war5"></div>

        <div class="m1L m1T p1B borderB color656565 flexBox2">
            <div class="w160">换汇年交易笔数<span class="colorEF7E2E">*</span></div>
            <input value="<?=$data['CASH']['trades_per_year']?>" class="input-width show valimessage6" placeholder = "请输入笔数" name="trades1" />
            <div class="w-90 m1R">笔交易｜年</div>
        </div>
        <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war6"></div>

        <div class="m1L m1T p1B borderB color656565 flexBox1" @click="show('3')">
            <div class="flexBox2">
                <div class="w160">换汇知识水平<span class="colorEF7E2E">*</span></div>
                <span class="color232323">{{choseData3}}</span>
            </div>
            <div class="sj m1R"></div>
        </div>
        <ul class="color303030 f33 none" :class="obj['3'].on" ref="select3">
            <li class="p05T p05B borderB p1L" v-for='item in list3' @click="chose(item,'3')">{{item.name}}</li>
        </ul>
        <input type="hidden" :value="choseId3" class="valimessage7" name="level1" />
        <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war7"></div>




        <div class="flexBox1 m1L m1R m1T bottom w100_" :class="showfixed">
            <div class="color464646 borderAll p05T p05B radius20px cenetr w160 m1R relative">
                上一步
                <a href="<?= Url::to(['objective', 'Customer_id' => $Customer_id])?>" class="fileInput"></a>
            </div>
            <div class="f33 bgEF7E2E colorFFF cenetr p05T p05B radius20px w100_" @click="nextsubmit()">
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
            list0:['是','否'],
            list1:<?=$level?>,
            list2:['是','否'],
            list3:<?=$level?>,
            choseData0:'是',
            choseData1:'<?=$data['stklevel']?>'!='' ? '<?=$data['stklevel']?>' : '请选择',
            choseData2:'<?=$data['CASH']['asset_class']?>'=='CASH'? '是' : '否',
            choseData3:'<?=$data['cashlevel']?>'!='' ? '<?=$data['cashlevel']?>' : '请选择',
            choseId0:'是',
            choseId1:'<?=$data['STK']['knowledge_level']?>',
            choseId2:'<?=$data['CASH']['asset_class']?>'=='CASH'? '是' : '否',
            choseId3:'<?=$data['CASH']['knowledge_level']?>',
            activeFixed:true,
            obj:[
                {on:'',switch:false},{on:'',switch:false},
                {on:'',switch:false},{on:'',switch:false}
            ]
        },
        mounted:function(){

        },
        computed:{
            showfixed:function(){
                return this.activeFixed?'fixed':''
            },
        },
        methods:{
            chose:function(data,index){
                if(index=='0' || index=='2'){
                    this['choseData'+index]=data
                    this['choseId'+index]=data
                }else{
                    this['choseData'+index]=data.name
                    this['choseId'+index]=data.value
                }
                this.show(index)
            },
            show:function(index){
                this.obj[index].switch=!this.obj[index].switch
                this.obj[index].switch?this.obj[index].on='show':this.obj[index].on=''
                this.obj[index].switch?this.on='show':this.on=''
                var flag = false;
                for(var i=0;i<this.obj.length;i++){
                    if(this.obj[index].switch){
                        flag = true;break;
                    }
                }
                if(flag){
                    this.activeFixed = false;
                }else{
                    this.activeFixed = true;
                }
            },
            valiheight:function(){
                var boxH = document.getElementsByClassName("box")[0].clientHeight;
                var windowH = window.screen.height;
                if(windowH - 100 < boxH){
                    this.activeFixed = false;
                }else{
                    this.activeFixed = true;
                }
            },
            valimessage:function(index,title){
                var value = $(".valimessage"+index).val();
                var i = parseInt(index);
                var reg2 = /^[0-9]*$/;
                if(value.trim()!=''){
                    if((index=='1'||index=='2'||index=='5'||index=='6') && !reg2.test(value)){
                        $(".war"+index).text(title+"必须是数字");
                        $(".war"+index).show();
                        return false;
                    }else{
                        if(index=='1' && parseFloat(value)<1){
                            $(".war"+index).text("股票交易年限需大于等于一年");
                            $(".war"+index).show();
                            return false;
                        }else{
                            $(".war"+index).hide();
                            return true;
                        }
                    }
                }else{
                    $(".war"+index).text(title+"不能为空");
                    $(".war"+index).show();
                    return false;
                }
                this.valiheight();
            },
            nextsubmit:function(){
                var that = this;
                if(that['choseId0'] != '是'){
                    $(".war0").text("请选择开通股票交易");
                    $(".war0").show();
                    this.valiheight();
                }else{
                    $(".war0").hide();
                    if(that.valimessage('1','请输入股票交易年限') && that.valimessage('2','请输入股票年交易笔数') && that.valimessage('3','请选择股票知识水平')){
                        var tab_cash = (that['choseId2'] == '是' ? true :false);
                        if(!tab_cash || (tab_cash && that.valimessage('5','请输入换汇交易年限') && that.valimessage('6','请输入换汇年交易笔数') && that.valimessage('7','请选择换汇知识水平'))){
                            $('#next').trigger('click');
                            // console.log("提交submit");
                        }
                    }
                }
            }
        }
    });
</script>