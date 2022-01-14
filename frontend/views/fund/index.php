<?php

use common\models\Identity;
use yii\helpers\Url;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\Candidate;
use common\models\Phone;
use common\metronic\widgets\ActiveForm;
use common\metronic\widgets\ActiveField;

$this->title = '转入资金';
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
    [v-cloak] {
        display: none;
    }
    .bgf2f2f2{
        background: #f2f2f2;
    }
    .colF08023{
        color: #F08023;
    }
    .col5A5A5A{
        color: #5A5A5A;;
    }
    .fz{
        color: #656565;
        background: #F3F3F3;
        padding:2px 4px;
        border-radius: 4px;
    }
    .btn{
        background: #EF7E2E;
        border-radius: 10px;
        padding: 12px 0;
        color: #FFFFFF;
        font-size: 0.968rem;
        text-align: center;
    }
    .line{
        text-decoration: underline;
    }
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
    .inputW{
        width: calc(100% - 140px);
    }
</style>

<script type="text/javascript" src="/js/vue@2.js"></script>
<script type="text/javascript" src="/js/clipboard.min.js"></script>
<div id="rj" v-cloak>
    <div class="m05T bgffffff p1L p1R p1T color656565">
        <div class="f40 color272727 bold">银行转账信息</div>
        <div class="flexBox1 m1T">
            <span>账户名称:</span>
            <div class="flexBox1">
                <span>INTERACTIVE BROKERS AU</span>&nbsp;&nbsp;
                <span class="fz" data-clipboard-text="INTERACTIVE BROKERS AU" @click="copy('INTERACTIVE BROKERS AU')">复制</span>
            </div>
        </div>
        <div class="flexBox1 m1T">
            <span>BSB:</span>
            <div class="flexBox1">
                <span>342 011</span>&nbsp;&nbsp;
                <span class="fz" data-clipboard-text="342011" @click="copy('342011')">复制</span>
            </div>
        </div>
        <div class="flexBox1 m1T">
            <span>账户号码(ACCOUNT NO):</span>
            <div class="flexBox1">
                <span>528056001</span>&nbsp;&nbsp;
                <span class="fz" data-clipboard-text="528056001" @click="copy('528056001')">复制</span>
            </div>
        </div>
        <div class="flexBox1 m1T">
            <span>转账备注:</span>
            <div class="flexBox1">
                <span><?= $account ?></span>&nbsp;&nbsp;
                <span class="fz" data-clipboard-text="<?= $account ?>" @click="copy('<?= $account ?>')">复制</span>
            </div>
        </div>
        <div class="f24 colorFF7F24 m05T p1B">转账备注必填，若未填写将有可能汇款失败</div>
    </div>
    <?php $form = ActiveForm::begin([
        'id' => 'contact-form',
        'enableClientValidation' => true,
//    'enableAjaxValidation' => true,
    ]) ?>
        <div class="m05T bgffffff p1T">
            <div class="f40 color272727 p1L p1R bold">通知财猫收款</div>
            <div class="f24 colorFF7F24 bgfef1e6 p1L p05B p05T m1T">请您前往银行网点或网银转账，转账完成后请填写汇款信息通知 给财猫证券。</div>
            <div class="m1L m1T p1B borderB color656565 flexBox1" @click="show('0')">
                <div class="flexBox2">
                    <div class="w140">汇款银行<span class="colorEF7E2E">*</span></div>
                    <span class="colorADADAD">{{choseData0?choseData0:'请选择'}}</span>
                    <?= $form->field($model, 'bankName')
                        ->textInput(['class'=>'none', ':value' => 'choseValue0'])
                        ->label(false)->error(false) ?>
                </div>
                <div class="sj m1R"></div>
            </div>
            <ul class="color303030 f33 none" :class="obj['0'].on" ref="select0">
                <li class="p05T p05B borderB p1L" v-for='item in list0' @click="chose(item,'0')">{{item.name}}</li>
            </ul>
            <?php if($model->hasErrors('bankName')):?>
                <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6"><?= $model->getErrors('bankName')[0] ?></div>
            <?php endif;?>

            <div class="m1L borderB color656565 flexBox2 inputH">
                <div class="w140">银行账号<span class="colorEF7E2E">*</span></div>
<!--                <input class="inputW" placeholder='银行账号/ACCOUNT NO.' value=""/>-->
                <?= $form->field($model, 'bankAccount')
                    ->textInput(['class'=>'inputW', 'placeholder'=>'银行账号/ACCOUNT NO.', 'style'=>'font-size:16px'])
                    ->label(false)->error(false) ?>
            </div>
            <?php if($model->hasErrors('bankAccount')):?>
                <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6"><?= $model->getErrors('bankAccount')[0]?></div>
            <?php endif;?>

            <div class="m1L m1T p1B borderB color656565 flexBox1" @click="show('1')">
                <div class="flexBox2">
                    <div class="w140">汇款币种<span class="colorEF7E2E">*</span></div>
                    <span class="color232323">{{choseData1?choseData1:'澳币AUD'}}</span>
                    <?= $form->field($model, 'currency')
                        ->textInput(['class'=>'none', ':value' => 'choseValue1'])
                        ->label(false)->error(false) ?>
                </div>
                <div class="sj m1R"></div>
            </div>
            <ul class="color303030 f33 none" :class="obj['1'].on" ref="select1">
                <li class="p05T p05B borderB p1L" v-for='item in list1' @click="chose(item,'1')">{{item.name}}</li>
            </ul>
            <?php if($model->hasErrors('currency')):?>
                <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6"><?= $model->getErrors('currency')[0] ?></div>
            <?php endif;?>

            <div class="m1L color656565 flexBox2 inputH borderB">
                <div class="w140">汇款金额<span class="colorEF7E2E">*</span></div>
<!--                <input type="number" class="inputW" placeholder='请输入汇款金额' onfocus="this.placeholder=''"/>-->
                <?= $form->field($model, 'amount')
                    ->textInput(['type'=>'number', 'class'=>'inputW', 'placeholder'=>'请输入汇款金额', 'onfocus'=>"this.placeholder=''", 'style'=>'font-size:16px'])
                    ->label(false)->error(false) ?>
            </div>
            <?php if($model->hasErrors('amount')):?>
                <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6"><?= $model->getErrors('amount')[0] ?></div>
            <?php endif;?>
        </div>

        <div class="f24 color878787 m1L m1R m1T">
            <div class="m05B">建议单次汇款金额大于等于3000澳币。</div>
            <div class="m05B">单笔汇款请发起单笔汇款通知，若多笔汇款只发起单个入金通知，将导致无法完成入账。</div>
            <div class="m05B">如有疑问，<span class="colF08023 line" @click="help()">联系在线客服。</span></div>
        </div>

        <div class="m1L f27 col5A5A5A flexBox5 m1T">
            <?= $form->field($model, 'isSave')
                ->MySwitch(['id'=>"switch0", 'label'=>false, ':value' =>'check0', '@click' => 'getSwitch(0,$event)'])
                ->label(false) ?>
            <span>保存为模版下次继续使用。</span>
        </div>

        <div class="btn m1L m1R m15T m15B" @click="nextSubmit()">
            确认已汇款，通知财猫收款
            <input type="submit" class="divHide" id="next">
        </div>
    <?php ActiveForm::end() ?>
</div>

<script type="text/javascript">
    new Vue({
        el:"#rj" ,
        data:{
            on:'',
            list0:[
                {'name':'CBA', 'value':'CBA'},
                {'name':'ANZ', 'value':'ANZ'},
                {'name':'Westpac', 'value':'Westpac'},
                {'name':'ANB', 'value':'ANB'},
                {'name':'Macquarie', 'value':'Macquarie'},
                {'name':'St George', 'value':'St George'},
                {'name':'CiTi花旗', 'value':'CiTi花旗'},
            ],
            list1:[
                {'name':'澳币AUD', 'value':'AUD'},
                // {'name':'美元USD', 'value':'USD'},
                // {'name':'港币HKD', 'value':'HKD'}
            ],
            choseData0:'<?= $model->bankName != null ? $model->bankName : 'CBA'?>',
            choseValue0: '<?= $model->bankName != null ? $model->bankName : 'CBA'?>',
            choseData1:'澳币AUD',
            choseValue1: 'AUD',
            check0: '<?= $model->isSave != null ? $model->isSave : '0'?>',
            obj:[
                {
                    on:'',
                    switch:false
                },
                {
                    on:'',
                    switch:false
                }
            ]
        },
        mounted:function(){
            const btnCopy = new ClipboardJS('.fz');
            btnCopy.on('success', function(e) {
                console.info('Action:', e.action); // 动作名称，比如：Action: copy
                console.info('Text:', e.text); // 内容，比如：Text：hello word
                console.info('Trigger:', e.trigger); // 触发元素：比如：<button class="btn" :data-clipboard-text="copyValue">点我复制</button>
                e.clearSelection(); // 清除选中内容
                alert("复制成功");
            });

            // 复制失败后执行的回调函数
            btnCopy.on('error', function(e) {
                console.error('Action:', e.action);
                console.error('Trigger:', e.trigger);
                alert("复制失败");
            });
            <?php if($isNew == 0) :?>
                alert('<?= $message ?>');
            <? endif;?>
        },
        methods:{
            chose:function(data,index){
                this['choseData'+index]=data.name
                this['choseValue'+index]=data.value
                this.obj[index].switch=!this.obj[index].switch
                this.obj[index].switch?this.obj[index].on='show':this.obj[index].on=''
                this.obj[index].switch?this.on='show':this.on=''
            },
            show:function(index){
                this.obj[index].switch=!this.obj[index].switch
                this.obj[index].switch?this.obj[index].on='show':this.obj[index].on=''
                this.obj[index].switch?this.on='show':this.on=''
            },
            nextSubmit:function(){
                $('#next').trigger('click');
            },
            help:function (){
                window.location.href = "https://m.moneycatrading.com/mobile/zendesk/index.html";
            },
            copy:function (value){

            },
            getSwitch:function(index,ev){
                if (this['check'+index]=='0')
                    this['check'+index]='1'
                else
                    this['check'+index]='0'
            },
        }
    });
</script>