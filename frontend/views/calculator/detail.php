<?php

$this->title = '套餐详情';
?>
<link rel="stylesheet" href="/calculator/css/Calculator.css"/>
<div id="Calculator">
    <div class="bgFFF pa68-73 mT20">
        <div class="center colF27616 f76 bold"><?=$data['total1']?></div>
        <div class="center col272727 f30 bold mb68">总费用(<?=$data['currencyname']?>)</div>
        <div class="flexBox1 center">
            <div>
                <div class="f33 col000 bold"><?=$data['name']?></div>
                <div class="f30 col555 maT5">股票</div>
            </div>
            <div>
                <div class="f33 col000 bold"><?=$data['price']?></div>
                <div class="f30 col555 maT5">价格</div>
            </div>
            <div>
                <div class="f33 col000 bold"><?=$data['num']?></div>
                <div class="f30 col555 maT5">数量</div>
            </div>
        </div>
    </div>

    <div class="bgFFF mT20">
        <div class="f30 col000 borderB H91 bold maL20 mab968">财猫收费详情</div>
        <div class="flexBox1 pa0-20 mab968">
            <span class="col65">收费项</span>
            <span class="col23"> 费用</span>
        </div>
        <div class="flexBox1 pa0-20 mab968">
            <span class="col65">交易佣金</span>
            <span class="col23"><?=$data['commission']?></span>
        </div>
        <?php if($data['currency']!='USD'):?>
        <div class="flexBox1 pa0-20 mab968">
            <span class="col65">交易所费用</span>
            <span class="col23"><?=$data['exchange']?></span>
        </div>
        <div class="flexBox1 pa0-20 mab968">
            <span class="col65">结算费用</span>
            <span class="col23"><?=$data['settlement']?></span>
        </div>
        <?php else :?>
        <div class="flexBox1 pa0-20 mab968">
            <span class="col65">清算费</span>
            <span class="col23"><?=$data['liquidation']?></span>
        </div>
        <div class="flexBox1 pa0-20 mab968">
            <span class="col65">NYSE代收费</span>
            <span class="col23"><?=$data['agentNYSE']?></span>
        </div>
        <div class="flexBox1 pa0-20 mab968">
            <span class="col65">FINRA代收费</span>
            <span class="col23"><?=$data['agentFINRE']?></span>
        </div>
        <div class="flexBox1 pa0-20 mab968">
            <span class="col65">FINRA交易活动费</span>
            <span class="col23"><?=$data['exchangeFINRE']?></span>
        </div>
        <?php endif;?>
        <div class="flexBox1 pa0-20 H91">
            <span class="colF27616">总费用</span>
            <span class="colF27616"><?=$data['total']?></span>
        </div>
    </div>
    <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 ">*实际产生费用,请以实时结算汇率为准</div>
</div>
