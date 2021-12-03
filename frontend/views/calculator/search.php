<?php
$this->title = '佣金计算器';
?>
<link rel="stylesheet" href="/calculator/css/Calculator.css"/>
<style>
    .pswp__preloader__icn {
        opacity:0.75;
        width: 24px;
        height: 24px;
        margin:0 auto;
        -webkit-animation: clockwise 500ms linear infinite;
        animation: clockwise 500ms linear infinite;
    }

    /* The idea of animating inner circle is based on Polymer loading indicator by Keanu Lee https://blog.keanulee.com/2014/10/20/the-tale-of-three-spinners.html */
    .pswp__preloader__cut {
        position: relative;
        width: 12px;
        height: 24px;
        overflow: hidden;
        position: absolute;
        top: 0;
        left: 0;
    }

    .pswp__preloader__donut {
        box-sizing: border-box;
        width: 24px;
        height: 24px;
        border: 2px solid #000;
        border-radius: 50%;
        border-left-color: transparent;
        border-bottom-color: transparent;
        position: absolute;
        top: 0;
        left: 0;
        background: none;
        margin:0;
        -webkit-animation: donut-rotate 1000ms cubic-bezier(.4,0,.22,1) infinite;
        animation: donut-rotate 1000ms cubic-bezier(.4,0,.22,1) infinite;
    }

    @-webkit-keyframes clockwise {
        0% { -webkit-transform: rotate(0deg) }
        100% { -webkit-transform: rotate(360deg) }
    }
    @keyframes clockwise {
        0% { transform: rotate(0deg) }
        100% { transform: rotate(360deg) }
    }
    @-webkit-keyframes donut-rotate {
        0% { -webkit-transform: rotate(0) }
        50% { -webkit-transform: rotate(-140deg) }
        100% { -webkit-transform: rotate(0) }
    }
    @keyframes donut-rotate {
        0% { transform: rotate(0) }
        50% { transform: rotate(-140deg) }
        100% { transform: rotate(0) }
    }
</style>
<div id="Calculator" v-cloak>
    <div class="flexBox1 bgFFF pa26 searchBox">
        <img src="img/search.png" class="searchIcon"/>
        <form action="javascript:return true" class="searchform">
            <input class="search" type="text" v-model="searchName" placeholder="请输入股票名称/代码" @change="search($event)"/>
        </form>
<!--        <img src="/calculator/img/cha.png" class="searchX" v-if="isShow" @click="remove"/>-->
        <div class="f30 col98" class="cancel" @click="cancel">取消</div>
    </div>
    <div id="loading" class="bgFFF mT20 center" style="display: none;" >
        <div class="pswp__preloader__icn">
            <div class="pswp__preloader__cut">
                <div class="pswp__preloader__donut"></div>
            </div>
        </div>
        <div class="f30 col98 mT29 center">加载中, 请稍等...</div>
    </div>
    <div class="bgFFF mT20" v-if="searchList.length>0">
        <div v-for="item in searchList" @click="chose(item.name,item.price,item.currency)">
            <div class="pa133 flexBox2">
                <img src="/calculator/img/search.png" class="searchIcon"/>&nbsp;&nbsp;
                <span class="f500 f30 col333">{{item.name}}</span>&nbsp;&nbsp;
                <img :src="item.icon" class="HK"/>&nbsp;
                <span class="f28 col96999E">{{item.code}}</span>
            </div>
            <div class="searchBorder"></div>
        </div>
    </div>
</div>
<!--<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>-->
<script src="/calculator/js/vue@2.js"></script>
<script src="/js/jquery-1.11.0.js"></script>
<script>
    new Vue({
        el:"#Calculator",
        data:{
            searchName:'',
            commitStr:'',
            searchList:[],
        },
        computed:{
            isShow:function(){
                return this.searchName?true:false
            }
        },
        methods:{
            remove:function(){
                this.searchName='';
            },
            cancel:function(){
                history.back()
            },
            search:function(){
                if(this.searchName==''){
                    this.searchList.length=0
                    return false
                }else if(this.commitStr == this.searchName){
                    return false
                }
                this.commitStr = this.searchName
                // 请求接口
                var arrIndex = {};
                arrIndex['symbol'] = this.commitStr;
                var that = this;
                this.searchList=[];
                $("#loading").show();
                $.get('/calculator/stocks', arrIndex, function(res) {
                    $("#loading").hide();
                    if(res.errno==0){
                        // console.log(res.data)
                        for(var i=0;i<res.data.length;i++){
                            var obj={
                                name: res.data[i].name,
                                icon: res.data[i].icon,
                                code: res.data[i].code,
                                price: res.data[i].price,
                                currency: res.data[i].currency
                            }
                            that.searchList.push(obj);
                        }
                    }
                });
            },
            chose:function(name,price,currency){
                // 回到上一页面赋值
                // localStorage.name=name
                // localStorage.price=price
                window.location.href='index?name='+name+'&price='+price+'&currency='+currency;
            }
        }
    })
</script>

