<?php
use yii\helpers\Url;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

//$this->registerMetaTag(['name' => 'keywords', 'content' => 'xxxx']);
$this->title = '阅读&签署协议-财猫证券开户';
AppAsset::register($this);
?>
<style>
    html,body{
        height: 100%;
    }
    .signPad{
        position: absolute;
        width: 100%;
        height: 100%;
    }

    .signatureBox {
        position: fixed;
        bottom: 0px;
        width: 100%;
        height: 100%;
        background: darkgray;
        box-sizing: border-box;
        overflow: hidden;
        z-index: 100;
        /*display: flex;*/
        /*flex-direction: column;*/
        padding: 10px;
    }
    .canvasBox {
        padding: 0px 5px;
        height: 90%;
        width: 100%;
    }
    canvas {
        border: 1px solid gray;
    }
    .btnBox {
        height: 30px;
        padding: 5px;
        text-align: center;
        line-height: 30px;
    }
    .btnBox button {
        border: 1px solid snow;
        background: #EF7E2E;
        color: #fff;
        border-radius: 4px;
        padding: 2px 30px;
        margin: 0 15px;
        font-size: 14px;
    }
    .closeBox {
        text-align: center;
        height: 10%;
        margin-bottom: 10px;
    }
    .closeBox span {
        font-size: 15px;
        float: left;
    }
    .closeBox p {
        font-size: 22px;
        width: 30px;
        height: 30px;
        line-height: 30px;
        border-radius: 30px;
        border: none;
        background: gray;
        color: white;
        float: right;
    }
    @media only screen and (min-width: 730px) {
        .signatureBox {
            position: fixed;
            bottom: 0px;
            width: 100%;
            height: 100%;
            background: darkgray;
            box-sizing: border-box;
            overflow: visible;
        }
    }

    .spinner {
        /* margin: 100px auto; */
        width: 200px;
        height: 80px;
        text-align: center;
        font-size: 10px;
        top: 50%;
        left: 25%;
        position: fixed;
        display: none;
    }

    .spinner .ani {
        background-color: #EF7E2E;
        height: 100%;
        width: 6px;
        display: inline-block;

        -webkit-animation: stretchdelay 1.2s infinite ease-in-out;
        animation: stretchdelay 1.2s infinite ease-in-out;
    }

    .spinner .rect2 {
        -webkit-animation-delay: -1.1s;
        animation-delay: -1.1s;
    }

    .spinner .rect3 {
        -webkit-animation-delay: -1.0s;
        animation-delay: -1.0s;
    }

    .spinner .rect4 {
        -webkit-animation-delay: -0.9s;
        animation-delay: -0.9s;
    }

    .spinner .rect5 {
        -webkit-animation-delay: -0.8s;
        animation-delay: -0.8s;
    }

    @-webkit-keyframes stretchdelay {
        0%, 40%, 100% { -webkit-transform: scaleY(0.4) }
        20% { -webkit-transform: scaleY(1.0) }
    }

    @keyframes stretchdelay {
        0%, 40%, 100% {
            transform: scaleY(0.4);
            -webkit-transform: scaleY(0.4);
        }  20% {
               transform: scaleY(1.0);
               -webkit-transform: scaleY(1.0);
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
<!--<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>-->
<script type="text/javascript" src="/js/vue@2.js"></script>
<div id="vertify">
    <div class="bold f40 color272727 m1T m1L m1B">阅读签署并签名</div>
    <div class="f33 color272727 m1L">1.本人已核对并确认填写信息无误;</div>
    <div class="f33 color272727 m1L m05T">2.本人承诺规管信息无隐瞒;</div>
    <div class="borderAll m1L m15T m1R color656565 f33 cenetr p1T" @click="showPad">
        <img class="m15T" :src="signImg" ref="canvasImg"/>
        <p class="p1B m15T">点击签署姓名</p>
    </div>
    <div class="flexBox1 m1L m1R m1T fixed wBtnBox">
        <div class="prevBtn borderCACACA color000 bgffffff cenetr radius20px f33 p05T p05B relative">
            上一步
            <a href="<?= Url::to(['sure-info', 'Customer_id' => $Customer_id])?>" class="fileInput"></a></div>
        <div class="nextBtn f33 bgEF7E2E colorFFF cenetr  p05T p05B radius20px" @click="nextSubmit()">
            下一步
        </div>
    </div>
    <div class="signatureBox" :class="isShow">
        <div class="canvasBox" ref="canvasHW">
            <div class="closeBox">
                <span>请签名</span>
                <p @click="close">X</p>
            </div>
            <canvas
                @touchstart="touchStart"
                @touchmove="touchMove"
                @touchend="touchEnd"
                ref="canvasF"
                @mousedown="mouseDown"
                @mousemove="mouseMove"
                @mouseup="mouseUp"
                :width="cavWidth"
            ></canvas>
            <div class="btnBox">
                <button @click="surewrite">确认</button>
                <button @click="overwrite">重置</button>
            </div>
        </div>
    </div>
</div>

<div class="spinner">
    <div class="spintitle"> 处理中...</div>
    <div class="rect1 ani"></div>
    <div class="rect2 ani"></div>
    <div class="rect3 ani"></div>
    <div class="rect4 ani"></div>
    <div class="rect5 ani"></div>
</div>

<script type="text/javascript">
    new Vue({
        el:"#vertify" ,
        data:{
            isShow:'true',
            points: [],
            canvasTxt: null,
            startX: 0,
            startY: 0,
            moveY: 0,
            moveX: 0,
            endY: 0,
            endX: 0,
            w: null,
            h: null,
            isDown: false,
            color: "#000",
            linewidth: 3,
            isDraw: false, //签名标记
            cavWidth: 380,
            screenWidth: document.documentElement.clientWidth, // 屏幕宽度
            timer: false,
            signImg: "/img/icon_24.png",
        },
        computed: {
            isCollapse: {
                get () {
                    return this.screenWidth < 768
                },
                set () {
                }
            }
        },
        watch: {
            screenWidth (val) {
                if (!this.timer) {
                    let canvas = this.$refs.canvasF;
                    canvas.height = document.body.offsetHeight - 200;
                    canvas.width = document.body.offsetWidth - 30;
                    this.timer = true
                    let that = this
                    setTimeout(function () {
                        that.timer = false
                    }, 400)
                }
            }
        },
        mounted:function(){
            let canvas = this.$refs.canvasF;
            canvas.height = document.body.offsetHeight - 200;
            canvas.width = document.body.offsetWidth - 30;
            this.canvasTxt = canvas.getContext("2d");
            this.canvasTxt.strokeStyle = this.color;
            this.canvasTxt.lineWidth = this.linewidth;
            this.close();
            // 监听窗口大小
            window.addEventListener(
                'resize',
                () =>
                    (this.screenWidth =
                        ((document.documentElement.clientWidth - 40) * 2) / 3)
            )
        },
        methods:{
            showPad: function (){
                this.isShow = "show";
            },
            mouseDown(ev) {
                ev = ev || event;
                ev.preventDefault();

                let obj = {
                    x: ev.offsetX,
                    y: ev.offsetY
                };
                this.startX = obj.x;
                this.startY = obj.y;
                this.canvasTxt.beginPath();//开始作画
                this.points.push(obj);//记录点
                this.isDown = true;
            },
            mouseMove(ev) {
                ev = ev || event;
                ev.preventDefault();
                if (this.isDown) {
                    let obj = {
                        x: ev.offsetX,
                        y: ev.offsetY
                    };
                    this.moveY = obj.y;
                    this.moveX = obj.x;
                    this.canvasTxt.moveTo(this.startX, this.startY);//移动画笔
                    this.canvasTxt.lineTo(obj.x, obj.y);//创建线条
                    this.canvasTxt.stroke();//画线
                    this.startY = obj.y;
                    this.startX = obj.x;
                    this.points.push(obj);//记录点
                }
            },
            mouseUp(ev) {
                ev = ev || event;
                ev.preventDefault();
                if (1) {
                    let obj = {
                        x: ev.offsetX,
                        y: ev.offsetY
                    };
                    this.canvasTxt.closePath();//收笔
                    this.points.push(obj);//记录点
                    this.points.push({ x: -1, y: -1 });
                    this.isDown = false;
                }
            },
            touchStart(ev) {
                ev = ev || event;
                ev.preventDefault();
                if (ev.touches.length == 1) {
                    this.isDraw = true; //签名标记
                    let obj = {
                        x: ev.targetTouches[0].clientX,
                        y:
                            ev.targetTouches[0].clientY -
                            (this.$refs.canvasHW.offsetHeight * 0.1)
                    }; //y的计算值中：document.body.offsetHeight*0.5代表的是除了整个画板signatureBox剩余的高，this.$refs.canvasHW.offsetHeight*0.1是画板中标题的高
                    this.startX = obj.x;
                    this.startY = obj.y;
                    this.canvasTxt.beginPath();//开始作画
                    this.points.push(obj);//记录点
                }
            },
            touchMove(ev) {
                ev = ev || event;
                ev.preventDefault();
                if (ev.touches.length == 1) {
                    let obj = {
                        x: ev.targetTouches[0].clientX,
                        y:
                            ev.targetTouches[0].clientY -
                            (this.$refs.canvasHW.offsetHeight * 0.1)
                    };
                    this.moveY = obj.y;
                    this.moveX = obj.x;
                    this.canvasTxt.moveTo(this.startX, this.startY);//移动画笔
                    this.canvasTxt.lineTo(obj.x, obj.y);//创建线条
                    this.canvasTxt.stroke();//画线
                    this.startY = obj.y;
                    this.startX = obj.x;
                    this.points.push(obj);//记录点
                }
            },
            touchEnd(ev) {
                ev = ev || event;
                ev.preventDefault();
                if (ev.touches.length == 1) {
                    let obj = {
                        x: ev.targetTouches[0].clientX,
                        y:
                            ev.targetTouches[0].clientY -
                            (this.$refs.canvasHW.offsetHeight * 0.1)
                    };
                    this.canvasTxt.closePath();//收笔
                    this.points.push(obj);//记录点
                    this.points.push({ x: -1, y: -1 });//记录点
                }
            },
            overwrite() {
                this.canvasTxt.clearRect(
                    0,
                    0,
                    this.$refs.canvasF.width,
                    this.$refs.canvasF.height
                );
                this.points = [];
                this.isDraw = false; //签名标记
            },
            //关闭
            close() {
                this.canvasTxt.clearRect(
                    0,
                    0,
                    this.$refs.canvasF.width,
                    this.$refs.canvasF.height
                );
                this.points = [];
                this.$emit("close", false);
                this.isShow = "none";
            },
            //确认签名
            surewrite() {
                var imgBase64 = this.$refs.canvasF.toDataURL();
                console.log("保存签名成功" + imgBase64);
                console.log(this.isDraw);
                if (this.isDraw) {
                    alert("签名成功！");
                    // this.$emit("surewrite",false);
                    this.signImg = imgBase64;
                    this.$refs.canvasImg.style.width = '100%';
                    this.close();
                } else {
                    alert("请签名后再确认！");
                }
            },
            nextSubmit:function (){
                $('.spinner').show();
                var arrIndex = {};
                arrIndex['Customer_id'] = '<?= $Customer_id?>';
                $.get('/account/submit-application', arrIndex, function(s) {
                    var realData = s.data;
                    console.log(realData);
                    if (realData.status == 1 )
                    {
                        $('.spinner').hide();
                        alert("开户失败，请检查填写的信息");
                        return;
                    }
                    console.log(realData.data);
                    if(realData.data == undefined)
                    {
                        $('.spinner').hide();
                        alert("网络波动，请稍后再试");
                        return;
                    }

                    console.log(realData.data.accountType);
                    console.log(realData.data.tradingAccount);
                    var accountType = realData.data.accountType;
                    var account = realData.data.tradingAccount;
                    arrIndex['account_id'] = account;
                    $.get('/account/submit-application', arrIndex, function(s) {

                    });
                    window.location.href = "/info/success?Customer_id="+<?= $Customer_id?>+"&accountType="+accountType+"&account="+account;
                });
                var int=self.setInterval(this.tickleData,1000);
            },
            tickleData:function ()
            {
                var arrIndex = {};
                arrIndex['Customer_id'] = '<?= $Customer_id?>';
                $.get('/account/fetch-account', arrIndex, function(s) {
                    var realData = s.data;
                    console.log(realData);
                    if (realData.status == 1)
                        return;

                    if (realData.status == 500)
                    {
                        $('.spinner').hide();
                        alert("网络波动，请稍后再试");
                        return;
                    }

                    var accountType = realData.data.accountType;
                    var account = realData.data.tradingAccount;
                    arrIndex['account_id'] = account;
                    $.get('/account/submit-application', arrIndex, function(s) {

                    });
                    window.location.href = "/info/success?Customer_id="+<?= $Customer_id?>+"&accountType="+accountType+"&account="+account;
                });
            }
        }
    });
</script>
