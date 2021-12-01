<?php

$this->title = '佣金计算器';
?>
<link rel="stylesheet" href="/calculator/css/Calculator.css"/>
<div id="Calculator" v-cloak>
    <div class="bgFFF center pa0-31 mT20">
        <div class="colF27616 f76 pa101-0">{{total}}</div>
        <div class="flexBox2 H103 f30 borderB maR968">
            <div class="w left bold col333">股票</div>
            <div class="flexBox1 wInput">
                <input v-model="name" placeholder="请输入股票名称/代码" class="H103" @click="goSearch"/>
                <img src="/calculator/img/cha.png" class="cha" v-if="isShow" @click="remove"/>
            </div>
        </div>
        <div class="flexBox2 H103 f30 borderB maR968">
            <div class="w left bold col333">价格</div>
            <div class="flexBox1 wInput">
                <input type="number" v-model="price" class="H103"/>
                <div class="flexBox1">
                    <img v-if="price==0" src="/calculator/img/reduce2.png" class="addimg mR10"/>
                    <img v-else src="/calculator/img/reduce.png" class="addimg mR10" @click="reduce('0')"/>
                    <img v-if="name==''" src="/calculator/img/add2.png" class="addimg"/>
                    <img v-else src="/calculator/img/add.png" class="addimg" @click="add('0')"/>
                </div>
            </div>
        </div>
        <div class="flexBox2 H103 f30 maR968">
            <div class="w left bold col333">数量</div>
            <div class="flexBox1 wInput">
                <input type="number" v-model="num" class="H103"/>
                <div class="flexBox1">
                    <img v-if="num==0" src="/calculator/img/reduce2.png" class="addimg mR10"/>
                    <img v-else src="/calculator/img/reduce.png" class="addimg mR10" @click="reduce('1')"/>
                    <img v-if="name==''" src="/calculator/img/add2.png" class="addimg"/>
                    <img v-else src="/calculator/img/add.png" class="addimg" @click="add('1')"/>
                </div>
            </div>
        </div>
    </div>
    <div  v-if="isActive" class="bgEF7E2E borRadius42 cofff center H84 mT29 ma0-31" @click="toDetail">查看详情</div>
    <div  v-else  class="bgFFB17A borRadius42 cofff center H84 mT29 ma0-31">查看详情</div>
</div>
<!--<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>-->
<script src="/calculator/js/vue@2.js"></script>
<script>
    new Vue({
        el:"#Calculator",
        data:{
            name:'<?=$data['name']?>',
            price:'<?=$data['price']?>',
            num:0,
            currency:'<?=$data['currency']?>'
        },
        mounted:function(){
            // console.log('/////')
        },
        computed:{
            total:function(){
                return (this.price*this.num).toFixed(3)
            },
            isActive:function(){
                return this.price&&this.num&&this.name?true:false
            },
            isShow:function(){
                return this.name?true:false
            }
        },
        methods:{
            goSearch:function(){
                window.location.href="/calculator/search";
            },
            reduce:function(which){
                if(which=='0'){
                    this.price=this.numSub(this.price,0.001)
                    if(this.price<0){
                        this.price=0
                        return false
                    }
                }else{
                    this.num=this.numSub(this.num,100)
                    if(this.num<0){
                        this.num=0
                        return false
                    }
                }
            },
            add:function(which){
                // price   0.001
                // num   100
                if(which=='0'){
                    this.price=this.numAdd(this.price,0.001)

                }else{
                    this.num=this.numAdd(this.num,100)
                }

            },
            toDetail:function(){
                window.location.href='detail?name='+this.name+'&price='+this.price+'&num='+this.num+'&currency='+this.currency;
            },
            remove:function(){
                this.name=''
            },
            numSub:function(arg1,arg2){
                var r1,r2,m;
                try{r1=arg1.toString().split(".")[1].length}catch(e){r1=0}
                try{r2=arg2.toString().split(".")[1].length}catch(e){r2=0}
                m=Math.pow(10,Math.max(r1,r2))
                return (arg1*m-arg2*m)/m;
            },
            numAdd:function(arg1,arg2){
                var r1,r2,m;
                try{r1=arg1.toString().split(".")[1].length}catch(e){r1=0}
                try{r2=arg2.toString().split(".")[1].length}catch(e){r2=0}
                m=Math.pow(10,Math.max(r1,r2))
                return (arg1*m+arg2*m)/m;
            }
        }
    })
</script>


