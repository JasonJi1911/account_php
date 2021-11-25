<?php
use frontend\assets\AppAsset;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = '财猫证券开户';
AppAsset::register($this);

?>
<style>
    .inputW{
        width: calc(100% - 140px);
        color: #232323;
        font-size: 16px;
    }
    .m2T{
        margin-top: 2rem;
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
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<?php $form = ActiveForm::begin() ?>
<div id="vertify">
    <div class="box">
        <div class="bold f40 color272727 m1T m1L p05B">个人信息</div>
        <input type="hidden" value="" />
        <div class="f24 color878787 m1L m1B">仅用于开户审核，隐私信息严格保密！</div>
        <div class="colorEF7E2E f24 bgF8F8F8 p1L p05T p05B flexBox2 bold">
            <img src="../img/icon_18.png" style="width:1.15rem;"/>
            &nbsp;联系信息
        </div>

        <div class="m1L borderB color656565 flexBox2 inputH heightAuto">
            <div class="w140">姓<span class="colorEF7E2E">*</span></div>
            <input type="text" id="candidate-last_name" name="Candidate[last_name]" value="<?=$candidate['last_name']?>" placeholder='证件上的"姓/Family name"' aria-required="true" class="inputW valimessage0" @blur="valimessage('0','姓')">
        </div>
        <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war0"></div>

        <div class="m1L borderB color656565 flexBox2 inputH heightAuto">
            <div class="w140">名<span class="colorEF7E2E">*</span></div>
            <input type="text" id="candidate-first_name" name="Candidate[first_name]" value="<?=$candidate['first_name']?>" placeholder='证件上的"名/First name"' aria-required="true" class="inputW valimessage1" @blur="valimessage('1','名')">
        </div>
        <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war1"></div>

        <div class="m1L borderB color656565 flexBox1 inputH heightAuto" @click="show('0')">
            <div class="flexBox2">
                <div class="w140">称呼<span class="colorEF7E2E">*</span></div>
                <span class="color232323">{{choseData0?choseData0:'请选择'}}</span>
            </div>
            <div class="sj m1R"></div>
        </div>
        <ul class="color303030 f33 none" :class="obj['0'].on" ref="select0">
            <li class="p05T p05B borderB p1L" v-for='item in list0' @click="chose(item,'0')">{{item}}</li>
        </ul>
        <?= $form->field($candidate, 'salutation')->textInput(['class'=>'none', ':value' => 'choseData0'])->label(false) ?>

        <div class="m1L borderB color656565 flexBox2 inputH heightAuto">
            <div class="w140">联系电话<span class="colorEF7E2E">*</span></div>
            <input class="inputW" placeholder="请输入联系电话" value="<?=$data['phone']?>" readonly />
        </div>

        <div class="m1L borderB color656565 flexBox2 inputH heightAuto">
            <div class="w140">E－mail<span class="colorEF7E2E">*</span></div>
            <input type="text" id="candidate-email" name="Candidate[email]" value="<?=$candidate['email']?>" placeholder="请输入E－mail地址" aria-required="true" class="inputW valimessage2" @blur="valimessage('2','E－mail')">
        </div>
        <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war2"></div>

        <div class="m1L borderB color656565 flexBox1 inputH heightAuto" @click="showcity('1')">
            <div class="flexBox2">
                <div class="w140">居住州/省<span class="colorEF7E2E">*</span></div>
                <span class="colorADADAD">{{choseData1?choseData1:'请选择'}}</span>
            </div>
            <div class="sj m1R"></div>
        </div>
        <ul class="color303030 f33 none" :class="obj['1'].on" ref="select1">
            <li class="p05T p05B borderB p1L" v-for='item in list1' @click="chose(item,'1')">{{item.state_cn}}</li>
        </ul>
        <?= $form->field($resident, 'state')->textInput(['class'=>'none', ':value' => 'choseStateCode'])->label(false) ?>
        <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war5"></div>

        <div class="m1L borderB color656565 flexBox1 inputH heightAuto" @click="showcity('2')">
            <div class="flexBox2">
                <div class="w140">城市<span class="colorEF7E2E">*</span></div>
                <span class="colorADADAD">{{choseData2?choseData2:'请选择'}}</span>
            </div>
            <div class="sj m1R"></div>
        </div>
        <ul class="color303030 f33 none" :class="obj['2'].on" ref="select2" >
            <li class="p05T p05B borderB p1L" v-for='item in filterlist2' @click="chose(item,'2')">
                {{item.city_cn}}
            </li>
        </ul>
        <?= $form->field($resident, 'city')->textInput(['class'=>'none', ':value' => 'choseCity'])->label(false) ?>
        <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war6"></div>

        <div class="m1L borderB color656565 flexBox2 inputH heightAuto">
            <div class="w140">地址<span class="colorEF7E2E">*</span></div>
            <input type="text" id="resident-street" name="Resident[street]" placeholder="请输入地址" value="<?=$resident['street']?>" aria-required="true" class="inputW valimessage3" @blur="valimessage('3','地址')">
        </div>
        <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war3"></div>

        <div class="m1L borderB color656565 flexBox2 inputH heightAuto">
            <div class="w140 f34">邮编<span class="colorEF7E2E">*</span></div>
            <input type="text" id="resident-post" name="Resident[post]" placeholder="请输入邮编" value="<?=$resident['post']?>" aria-required="true" class="inputW valimessage4" @blur="valimessage('4','邮编')">
        </div>
        <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war4"></div>

        <div class="flexBox1 m1L m1R m1T wBtnBox m2B m2T">
            <div class="prevBtn borderCACACA color000 bgffffff cenetr radius20px f33 p05T p05B relative">
                上一步
                <a href="<?= Url::to(['account/identity-info', 'Customer_id' => $Customer_id])?>" class="fileInput"></a>
            </div>
            <div class="nextBtn f33 bgEF7E2E colorFFF cenetr  p05T p05B radius20px" @click="nextsubmit()">
                下一步
            </div>
            <input type="submit" class="divHide" id="next">
        </div>
    </div>
    <div class="mask none" :class="on"></div>
</div>
<?php ActiveForm::end() ?>
<script type="text/javascript">
    new Vue({
        el:"#vertify" ,
        data:{
            on:'',
            list0:['Mrs.','Mr.','Ms.','Dr.'],
            list1:<?=$state?>,
            list2:<?=$city?>,
            choseData0:'<?=($candidate['salutation']!='' ? $candidate['salutation'] : 'Mrs.')?>',
            choseData1:'<?=($data['state_cn']!='' ? $data['state_cn'] : '请选择')?>',
            choseData2:'<?=($data['city_cn']!='' ? $data['city_cn'] : '请选择')?>',
            choseStateCode:'<?=($resident['state']!='' ? $resident['state'] : '')?>',
            choseCity:'<?=($resident['city']!='' ? $resident['city'] : '')?>',
            obj:[{on:'',switch:false},{on:'',switch:false},{on:'',switch:false}],
        },
        mounted:function(){

        },
        methods:{
            chose:function(data,index){
                if(index=='1'){
                    this['choseData'+index]=data.state_cn
                    this['choseStateCode']=data.state_code
                    this['choseData2']='请选择'
                    this.showcity(index);
                }else if(index=='2'){
                    this['choseData'+index]=data.city_cn
                    this['choseCity']=data.city_en
                    this.showcity(index);
                }else{
                    this['choseData'+index]=data
                    this.show(index);
                }
                // this.obj[index].switch=!this.obj[index].switch
                // this.obj[index].switch?this.obj[index].on='show':this.obj[index].on=''
                // this.obj[index].switch?this.on='show':this.on=''
            },
            showcity:function(index){
                var otherindex = '';
                if(index=='1'){
                    otherindex = '2';
                    if(this.obj[otherindex].switch){
                        this.show(otherindex);
                    }
                }else if(index=='2'){
                    otherindex = '1';
                    if(this.obj[otherindex].switch){
                        this.show(otherindex);
                    }
                }
                this.show(index);
            },
            show:function(index){
                this.obj[index].switch=!this.obj[index].switch
                this.obj[index].switch?this.obj[index].on='show':this.obj[index].on=''
                this.obj[index].switch?this.on='show':this.on=''
            },
            valimessage:function(index,title){
                if(index=='5' || index=='6'){//州/省、城市
                    var name = index=='5' ? this['choseStateCode'] : this['choseCity'];
                    if(name!=''&&name!='请选择'){
                        //通过验证
                        $(".war"+index).hide();
                        return true;
                    }else{
                        $(".war"+index).text("请选择"+title);
                        $(".war"+index).show();
                        return false;
                    }
                }else{
                    //输入框验证
                    var value = $(".valimessage"+index).val();
                    if(value.trim() != ""){
                        var reg = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
                        var reg2 = /^[0-9]*$/;
                        if (index=='2' && !reg.test(value)) {
                            $(".war"+index).text("E-mail格式不正确");
                            $(".war"+index).show();
                            return false;
                        }else if (index=='4' && !reg2.test(value)) {
                            $(".war"+index).text("邮编必须是数字");
                            $(".war"+index).show();
                            return false;
                        }else{
                            //通过验证
                            $(".war"+index).hide();
                            return true;
                        }
                    }else{
                        $(".war"+index).text(title+"不能为空");
                        $(".war"+index).show();
                        return false;
                    }
                }
            },
            nextsubmit:function(){
                if(this.valimessage('0','姓') && this.valimessage('1','名') && this.valimessage('2','E-mail')
                    && this.valimessage('5','居住州/省') && this.valimessage('6','城市')
                    && this.valimessage('3','地址') && this.valimessage('4','邮编')){
                    $('#next').trigger('click');
                }
            },
        },
        computed: {
            filterlist2: function () {
                var choseStateCode = this['choseStateCode'];
                return this.list2.filter(function (list) {
                    if(choseStateCode!=''){
                        return list.state_code == choseStateCode;
                    }else{
                        return true;
                    }
                });
            }
        }
    });
</script>
