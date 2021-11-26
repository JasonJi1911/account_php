<?php
use frontend\assets\AppAsset;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = '财猫证券开户';
AppAsset::register($this);

?>
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
]) ?>
<style>
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
        background: url(../img/checked.png) no-repeat;
        background-size: 100% 100%;
        border-radius: 2px;
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

    <div class="bold f40 color272727 m1T m1L p05B">投资目标及交易意图</div>
    <div class="f24 color878787 m1L">您在下方的选择将决定您能够获批交易的资产产品。</div>

    <div class="m1T">
        <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war0">请勾选所有适用选项</div>
        <div v-for='(item,index) in list1'  class="flexBox1 m1L p1R p05T p05B borderB">
            <span>{{item.name}}</span>
            <div>
                <input type="checkbox" :id="item.value" name="invest-obj" disabled v-model="item.checked" />
                <label :for="item.value" v-model="item.checked"></label>
            </div>
        </div>
    </div>

<!--    <div class="flexBox1 m1L p1R p05T p05B borderB">-->
<!--        <span>增长</span>-->
<!--        <div>-->
<!--            <input type="checkbox" name="btn1"/><label for="btn1"></label>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="flexBox1 m1L p1R p05T p05B borderB">-->
<!--        <span>对冲</span>-->
<!--        <div>-->
<!--            <input type="checkbox" name="btn2"/><label for="btn2"></label>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="flexBox1 m1L p1R p05T p05B borderB">-->
<!--        <span>资本保值及创收</span>-->
<!--        <div>-->
<!--            <input type="checkbox" name="btn3"/><label for="btn3"></label>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="flexBox1 m1L p1R p05T p05B borderB">-->
<!--        <span>从活跃交易到投机中盈利</span>-->
<!--        <input type="checkbox" />-->
<!--    </div>-->
    <?= $form->field($account, 'InvestmentObjectives')->textInput(['class'=>'none', ':value' => 'choseId1'])->label(false) ?>
    <div class="flexBox1 m1L m1R m1T fixed wBtnBox">
        <div class="prevBtn borderCACACA color000 bgffffff cenetr radius20px f33 p05T p05B relative">
            上一步
            <a href="<?= Url::to(['accountinfo', 'Customer_id' => $Customer_id])?>" class="fileInput"></a>
        </div>
        <div class="nextBtn f33 bgEF7E2E colorFFF cenetr  p05T p05B radius20px" @click="nextsubmit()">
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
            list1:<?=$investObj?>,
            choseId1:'<?=$account['InvestmentObjectives']?>',
            filterlist1:['Growth','Hedging'],
            filterlist2:['Speculation','Trading']
        },
        mounted:function(){

        },
        methods:{
            nextsubmit:function(){
                var boxs = $('input[name="invest-obj"]');
                var investObjs = '';
                for (var x in boxs) {
                    if (boxs[x].checked){
                        if(investObjs != ''){
                            investObjs += "+" + boxs[x].id;
                        }else{
                            investObjs = boxs[x].id;
                        }
                    }
                }
                // console.log(investObjs);
                var tab = false;
                //过滤filterlist1
                for(var i=0;i<this.filterlist1.length;i++){
                    if(investObjs.indexOf(this.filterlist1[i])>=0){
                        tab = true;
                        break;
                    }
                }
                //成功过滤，filterlist2
                if(tab){
                    tab = false;
                    for(var n=0;n<this.filterlist2.length;n++){
                        if(investObjs.indexOf(this.filterlist2[n])>=0){
                            tab = true;
                            break;
                        }
                    }
                }
                if(tab) {
                   $('.war0').hide();
                   this.choseId1 = investObjs;
                   $('#next').trigger('click');
                }else{
                    $('.war0').show();
                }
                // console.log("choseId1="+this.choseId1);
            }
        }
    });
</script>