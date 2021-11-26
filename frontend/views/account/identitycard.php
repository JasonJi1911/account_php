<?php

use common\models\Identity;
use yii\helpers\Url;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\metronic\widgets\ActiveForm;
use common\models\Candidate;
use common\models\Phone;
use common\metronic\widgets\ActiveField;

$this->title = '上传证件-财猫证券开户';
AppAsset::register($this);

$js = <<<JS
$(function(){
    $("#divNext").click(function (){
        $('#next').trigger('click');
    });
});
JS;

$this->registerJs($js);
?>
<style>
    .fileInput{
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
        margin: 0;
        font-size: 23px;
        cursor: pointer;
        filter: alpha(opacity=0);
        opacity: 0;
        direction: ltr;
    }

    .pos-relative{
        position: relative;
    }

    .help-block_padding {
        padding-bottom: 0.5rem;
        padding-top: 0.5rem;
    }
</style>

<!--<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>-->
<script type="text/javascript" src="/js/vue@2.js"></script>
<?php $form = ActiveForm::begin([
    'id' => 'contact-form',
    'enableClientValidation' => true,
//    'enableAjaxValidation' => true,
]) ?>
<div class="bold f40 color272727 m1T m1L p05B">身份验证</div>
<div class="f24 color878787 m1L m1B">为了符合金融部门监管要求，请上传身份证件正面。</div>
<div class="color878787 f24 bgF8F8F8 p1L p05T p05B flexBox2">
    <img src="/img/icon_9.png" style="width:0.8rem;height:1rem"/>
    &nbsp仅用于开户审核，隐私信息严格保密！
</div>
<div id="app">
<?= $form->field($identity, 'picture')->imageUpload(['class'=>'fileInput', 'width' => '366px', 'height' => '210px', '@change'=>"upload"])
    ->label(false)->error(['class'=> $identity->hasErrors('picture') ? "help-block  help-block_padding": 'help-block']) ?>
</div>
<!--<div id="app">-->
<!--    <div class="m15L m15R radius20px bgF9F9F9 m1T cenetr">-->
<!--        <img :src="imgUrl" class="w100"/>-->
<!--        <div v-if="tips" class="cenetr textpos">证件正面照片</div>-->
<!--    </div>-->
<!--    <div class="fon500 bgF9F9F9 H80 linH80 cenetr m15L m15R radius14px m05T pos-relative">-->
<!--        从相册中选择-->
<!--        --><?//= $form->field($identity, 'picture')->imageUpload(['class'=>'fileInput', 'width' => '366px', 'height' => '210px'])->label(false) ?>
<!--    </div>-->
<!--</div>-->

<!-- <div class="m15L m15R radius20px bgF9F9F9 m1T cenetr">
    <img src="../img/icon_8.png" class="w100"/>
</div> -->
<div class="fixed"  style="width:100%;">
    <div class="color000 f24 bold m1L m1T">拍摄要求</div>
    <div class="flexBox1 m1T m1L m1R">
        <div class="w25">
            <img src="/img/icon_10.png" class="w100"/>
            <div class="cenetr f24"><img src="/img/icon_14.png" style="width:0.75rem;height:0.56rem;"/>&nbsp;标准</div>
        </div>
        <div class="w25">
            <img src="/img/icon_11.png" class="w100"/>
            <div class="cenetr f24"><img src="/img/icon_15.png" style="width:0.65rem;height:0.65rem;"/>&nbsp;边角缺失</div>
        </div>
        <div class="w25">
            <img src="/img/icon_12.png" class="w100"/>
            <div class="cenetr f24"><img src="/img/icon_15.png" style="width:0.65rem;height:0.65rem;"/>&nbsp;照片模糊</div>
        </div>
        <div class="w25">
            <img src="/img/icon_13.png" class="w100"/>
            <div class="cenetr f24"><img src="/img/icon_15.png" style="width:0.65rem;height:0.65rem;"/>&nbsp;反光强烈</div>
        </div>
    </div>
    <div style="height:4rem;"></div>
    <div class="flexBox1 m1L m1R m1T fixed wBtnBox">
        <div class="prevBtn borderCACACA color000 bgffffff cenetr radius20px f33 p05T p05B pos-relative">
            上一步
            <a href="<?= Url::to(['nationality', 'Customer_id' => $Customer_id])?>" class="fileInput"></a>
        </div>
        <div class="nextBtn f33 bgEF7E2E colorFFF cenetr  p05T p05B radius20px pos-relative" id="divNext">
            下一步
            <input type="submit" class="fileInput" id="next">
        </div>
    </div>
</div>

<?php ActiveForm::end() ?>

<script>
    var app = new Vue({
        el:"#app",
        data: {
            imgUrl: "",
            tips: true
        },
        mounted: function () {
            console.log(324);
            this.imgUrl = '<?= $identity->picture != null ? $identity->picture : '/img/icon_7.png'?>';
        },
        methods: {
            upload:function(e){
                //e.target指向事件执行时鼠标所点击区域的那个元素，那么为input的标签，
                // 可以输出 e.target.files 看看，这个files对象保存着选中的所有的图片的信息。
                console.log(e.target.files)
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
                    })
                }
                //------------------------------------------------------------
            }
        }
    })
</script>


