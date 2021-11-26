<?php
use frontend\assets\AppAsset;

$this->title = '财猫证券开户';
AppAsset::register($this);

?>
<!--<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>-->
<script type="text/javascript" src="/js/vue@2.js"></script>

<div id="vertify" class="m1L m1R">
    <div class="cenetr">
        <img src="../img/icon_23.png" class="m15T" style="width:3.8rem;height:3.8rem;"/>
    </div>
    <div class="cenetr m1T m15B color272727 bold f33">开户完成，审核中...</div>
    <div class="flexBox1 p05T p05B">
        <span class="color656565">账户类型</span>
        <span><?=$data['accountType']?></span>
    </div>
    <div class="flexBox1 p05T p05B">
        <span class="color656565">账户名称</span>
        <span><?=$data['name']?></span>
    </div>
    <div class="flexBox1 p05T p05B">
        <span class="color656565">交易账号</span>
        <span><?=$data['account']?></span>
    </div>
    <div class="flexBox1 p05T p05B borderB">
        <span class="color656565">顾问 / 经济商账户名称</span>
    </div>
    <div class="m15B m05T color272727 f33">
        money cat trading pay ltd as car of settie rs investemem anagem
    </div>
    <div class="f24 color878787 m05B cenetr">当前开户完成，我们会优先对已入金的账户进行审核</div>
    <div class="f33 bgEF7E2E colorFFF cenetr p05T p05B radius20px m1B">
        立即入金
    </div>
    <div class="f33 bgffffff colorEF7E2E borderEF7E2E cenetr p05T p05B radius20px ">
        返回财猫
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

        }
    });
</script>
