<?php
use frontend\assets\AppAsset;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = '财猫证券开户';
AppAsset::register($this);

?>
<!--<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>-->
<script type="text/javascript" src="/js/vue@2.js"></script>
<?php $form = ActiveForm::begin([
//    'id' => 'contact-form',
    'enableClientValidation' => false,
    'options' => ['enctype' => 'multipart/form-data'],
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
    .control-label{display: none;}
    #imgmaxH{
        width:100%;
        max-height:410px;
    }
</style>
<div id="vertify">
    <div class="bold f40 color272727 m1T m1L p05B">证明上传</div>
    <div class="f24 color878787 m1L m1R">请上传最近1-3个月的银行对账单或其他券商平台交易记录， 以确认您的资产状况。</div>
    <div class="borderAll m1L m1T m1R color656565 f33 cenetr p1T relative">
        <div :class="isShow">
            <img class="m15T" src="../img/icon_24.png" style="width:1.96rem;height:1.96rem;"/>
            <p class="m15T">点击上传文件</p>
            <p class="p1B">支持jpeg、png、pdf格式文件</p>
        </div>
        <div :class="isShow2">
            <img :src="imgUrl" id="imgmaxH" @error="errorImg" /><!--:style="{width: imgW, height: imgH}"-->
        </div>
        <?= $form->field($financial, 'imageFile')->fileInput([ '@change'=>"upload",'class'=>'fileInput']) ?>
    </div>
    <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6" :class="isShowError"><?=$data['error']?></div>

    <div class="flexBox1 m1L m1R m1T wBtnBox fixed" >
        <div class="prevBtn borderCACACA color000 bgffffff cenetr radius20px f33 p05T p05B relative">
            上一步
            <a href="<?= Url::to(['incomeasset', 'Customer_id' => $Customer_id])?>" class="fileInput"></a>
        </div>
        <div class="nextBtn f33 bgEF7E2E colorFFF cenetr  p05T p05B radius20px" @click="nextsubmit()">
            下一步
            <input type="submit" class="divHide" id="next">
        </div>
    </div>
</div>
<?php ActiveForm::end() ?>
<script src="/js/jquery-1.11.0.js"></script>
<script type="text/javascript">
    new Vue({
        el:"#vertify" ,
        data:{
            active:'<?=$financial['picture']?>'!=''?false:true,
            active2:'<?=$financial['picture']?>'!=''?true:false,
            activeError:'<?=$data['error']?>'!=''?true:false,
            imgUrl:'<?=$financial['picture']!=''? $financial['picture'] : ''?>',
            imgH:'100%',
            imgW:'100%',
        },
        mounted:function(){
            // var that = this;
            // //加载图片获取图片真实宽度和高度
            // var image = new Image();
            // image.src = this.imgUrl;
            // image.onload = function () {
            //     var imgW = this.width;
            //     var imgH = this.height;
            //     var screenW = window.screen.width;
            //     var screenH = window.screen.height;
            //     if(imgW / screenW * screenH < imgH){
            //         that.imgW = 'auto';
            //         that.imgH = (screenH-230)+'px';
            //     }else{
            //         that.imgW = '100%';
            //         that.imgH = 'auto';
            //     }
            // };
        },
        computed: {
            isShow: function () {
                return this.active ? 'show' : 'none'
            },
            isShow2: function () {
                return this.active2 ? 'show' : 'none'
            },
            isShowError: function () {
                return this.activeError ? 'show' : 'none'
            },
        },
        methods:{
            imgevent:function(){
                var that = this;
                //加载图片获取图片真实宽度和高度
                var image = new Image();
                image.src = this.imgUrl;
                image.onload = function () {
                    var imgW = this.width;
                    var imgH = this.height;
                    var screenW = window.screen.width;
                    var screenH = window.screen.height;
                    if(imgW / screenW * screenH < imgH){
                        that.imgW = 'auto';
                        that.imgH = (screenH-230)+'px';
                    }else{
                        that.imgW = '100%';
                        that.imgH = 'auto';
                    }
                };
            },
            errorImg:function(){
                this.active = true;
                this.active2 = false;
            },
            upload:function(e){
                //e.target指向事件执行时鼠标所点击区域的那个元素，那么为input的标签，
                // 可以输出 e.target.files 看看，这个files对象保存着选中的所有的图片的信息。
                // console.log(e.target.files);
                //------------------------------------------------------
                // 既然如此，循环这个files对象，用for of 循环，
                for(let item of e.target.files){
                    //正则表达式，判断每个元素的type属性是否为图片形式，如图
                    if (!/image\/\w+/.test(item.type)) {
                        // 提示只能是图片，return
                        alert("只能选择图片");
                        return;
                    }
                    // 保存下当前 this ，就是vue实例
                    var _this = this;
                    //  创建一个FileReader()对象，它里面有个readAsDataURL方法
                    let reader = new FileReader();
                    // readAsDataURL方法可以将上传的图片格式转为base64,然后在存入到图片路径,
                    //这样就可以上传电脑任意位置的图片
                    reader.readAsDataURL(item);
                    //文件读取成功完成时触发
                    reader.addEventListener('load',function(){
                        //  reader.result返回文件的内容。
                        //只有在读取操作完成后，此属性才有效，返回的数据的格式取决于是使用哪种读取方法来执行读取操作的。
                        //给数组添加这个文件也就是图片的内容
                        _this.tips = false
                        _this.imgUrl = this.result
                        _this.active = false
                        _this.active2 = true
                        // _this.imgevent();
                    });
                }
            },
            nextsubmit:function(){
                $('#next').trigger('click');
            }
        }
    });
</script>