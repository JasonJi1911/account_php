<?php
use frontend\assets\AppAsset;
use yii\helpers\Url;

$this->title = '财猫证券开户';
AppAsset::register($this);

?>
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
        background: url(/img/checked.png) no-repeat;
        background-size: 100% 100%;
        border-radius: 2px;
    }
    .H106{
        height: 3.3125rem;
        border-bottom: 1px solid #dfebff;
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
<script type="text/javascript" src="/js/vue@2.js"></script>
<div id="vertify">

    <div class="bold f40 color272727 m1T m1L p05B">交易股票权限</div>
    <div class="f24 color878787 m1L">请选择您要交易的股市信息</div>

    <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 m1T">建议您勾选全部项目</div>

    <div class="flexBox1 m1L p1R p05T p05B H106">
        <span class="f33 color303030">美股</span>
        <div>
            <input checked type="checkbox" name="btn1" class="btn-stk"/>
        </div>
    </div>
    <div class="flexBox1 m1L p1R p05T p05B H106">
        <span class="f33 color303030">澳股</span>
        <div>
            <input checked type="checkbox" name="btn2"/>
        </div>
    </div>
    <div class="flexBox1 m1L p1R p05T p05B H106">
        <span class="f33 color303030">港股</span>
        <div>
            <input checked type="checkbox" name="btn3"/>
        </div>
    </div>

    <div class="f40 color272727 bold m1L m15T">货币兑换</div>
    <div class="flexBox1 m1L p1R p05T p05B H106">
        <span class="f33 color303030">允许进行货币兑换</span>
        <input checked type="checkbox" class="btn-res"/>
    </div>
    <div class="flexBox1 m1L m1R m1T fixed wBtnBox">
        <div class="prevBtn borderCACACA color000 bgffffff cenetr radius20px f33 p05T p05B relative">
            上一步
            <a href="<?= Url::to(['info/experience', 'Customer_id' => $Customer_id])?>" class="fileInput"></a>
        </div>
        <div class="nextBtn f33 bgEF7E2E colorFFF cenetr  p05T p05B radius20px" @click="nextsubmit()">
            下一步
        </div>
    </div>
</div>

<script type="text/javascript">
    new Vue({
        el:"#vertify" ,
        data:{

        },
        mounted:function(){

        },
        methods:{
            nextsubmit:function(){
                var stkChecked = 0;
                $('.btn-stk').each(function (){
                    if ($(this).is(':checked'))
                        stkChecked = 1;
                });
                if (stkChecked == 0)
                {
                    alert("股票权限至少选择一个");
                    return;
                }

                var resChecked = 0;
                $('.btn-res').each(function (){
                    if ($(this).is(':checked'))
                        resChecked = 1;
                });
                if (resChecked == 0)
                {
                    alert("换汇权限必须选择");
                    return;
                }

                window.location.href = "/account/regulatory?Customer_id="+<?= $Customer_id?>;
            }
        }
    });
</script>
