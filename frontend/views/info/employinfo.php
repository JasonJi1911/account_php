<?php
use frontend\assets\AppAsset;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = '财猫证券开户';
AppAsset::register($this);

?>
<link rel="stylesheet" type="text/css" href="/css/label.css" />
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<?php $form = ActiveForm::begin([
    'id' => 'contact-form',
    'enableClientValidation' => false,
]) ?>
<style>
    input{font-size: 16px;}
    .help-block{display: none;}
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
<div id="vertify">
    <div class="box">
        <div class="bold f40 color272727 m1T m1L p05B">个人信息</div>
        <div class="f24 color878787 m1L m1B">仅用于开户审核，隐私信息严格保密！</div>
        <div class="colorEF7E2E f33 bgF8F8F8 p1L p05T p05B flexBox2 bold">
            <img src="../img/icon_20.png" style="width:20px;"/>
            &nbsp;雇佣信息
        </div>
        <div class="m1L m1T p1B borderB color656565 flexBox1" @click="show('0')">
            <div class="flexBox2">
                <div class="w140">就业状况<span class="colorEF7E2E">*</span></div>
                <span class="color232323">{{choseData0?choseData0:'请选择'}}</span>
            </div>
            <div class="sj m1R"></div>
        </div>
        <ul class="color303030 f33 none" :class="obj['0'].on" ref="select0">
            <li class="p05T p05B borderB p1L" v-for='item in list0' @click="chose(item,'0')">{{item.name}}</li>
        </ul>
        <?= $form->field($candidate, 'employment_type')->textInput(['class'=>'none', ':value' => 'choseId0'])->label(false) ?>
        <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war0"></div>

        <div :class="isShowEM">
            <div class="m1L m1T p1B borderB color656565 flexBox2">
                <div class="w140">雇佣单位<span class="colorEF7E2E">*</span></div>
                <?= $form->field($employment, 'employer_name')->textInput(['class'=>'show valimessage11', 'placeholder'=>'请填写完整的单位名称', 'value'=>$employment['employer_name'], '@blur'=>"valimessage('11','雇佣单位','input')"])->label(false) ?>
            </div>
            <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war11"></div>

            <div class="m1L m1T p1B borderB color656565 flexBox1" @click="show('1')">
                <div class="flexBox2">
                    <div class="w140">国家/地区<span class="colorEF7E2E">*</span></div>
                    <span class="colorADADAD">{{choseData1?choseData1:'请选择'}}</span>
                </div>
                <div class="sj m1R"></div>
            </div>
            <ul class="color303030 f33 none" :class="obj['1'].on" ref="select1">
                <li class="p05T p05B borderB p1L" v-for='item in list1' @click="chose(item,'1')">{{item.name}}</li>
            </ul>
            <?= $form->field($employment, 'country')->textInput(['class'=>'none', ':value' => 'choseId1'])->label(false) ?>
            <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war1"></div>

            <div class="m1L m1T p1B borderB color656565 flexBox1" @click="showRelated('2','3')">
                <div class="flexBox2">
                    <div class="w140">签发州/省<span class="colorEF7E2E">*</span></div>
                    <span class="colorADADAD">{{choseData2?choseData2:'请选择'}}</span>
                </div>
                <div class="sj m1R"></div>
            </div>
            <ul class="color303030 f33 none" :class="obj['2'].on" ref="select2">
                <li class="p05T p05B borderB p1L" v-for='item in list2' @click="choseRelated(item,'2','3')">{{item.name}}</li>
            </ul>
            <?= $form->field($employment, 'state')->textInput(['class'=>'none', ':value' => 'choseId2'])->label(false) ?>
            <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war2"></div>

            <div class="m1L m1T p1B borderB color656565 flexBox1" @click="showRelated('3','2')">
                <div class="flexBox2">
                    <div class="w140">城市<span class="colorEF7E2E">*</span></div>
                    <span class="colorADADAD">{{choseData3?choseData3:'请选择'}}</span>
                </div>
                <div class="sj m1R"></div>
            </div>
            <ul class="color303030 f33 none" :class="obj['3'].on" ref="select3">
                <li class="p05T p05B borderB p1L" v-for='item in filterlist("3")' @click="choseRelated(item,'3','2')">{{item.name}}</li>
            </ul>
            <?= $form->field($employment, 'city')->textInput(['class'=>'none', ':value' => 'choseId3'])->label(false) ?>
            <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war3"></div>

            <div class="m1L m1T p1B borderB color656565 flexBox2">
                <div class="w140">地址<span class="colorEF7E2E">*</span></div>
                <?= $form->field($employment, 'street_1')->textInput(['class'=>'show valimessage12', 'placeholder'=>'请填写地址', 'value'=>$employment['street_1'], '@blur'=>"valimessage('12','地址','input')"])->label(false) ?>
            </div>
            <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war12"></div>

            <div class="m1L m1T p1B borderB color656565 flexBox2">
                <div class="w140">邮编<span class="colorEF7E2E">*</span></div>
                <?= $form->field($employment, 'postal_code')->textInput(['class'=>'show valimessage13', 'placeholder'=>'请输入邮编', 'value'=>$employment['postal_code'], '@blur'=>"valimessage('13','邮编','input')"])->label(false) ?>
            </div>
            <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war13"></div>

            <div class="m1L m1T p1B borderB color656565 flexBox1" @click="showRelated('4','5')">
                <div class="flexBox2">
                    <div class="w140">商业性质<span class="colorEF7E2E">*</span></div>
                    <span class="colorADADAD">{{choseData4?choseData4:'请选择'}}</span>
                </div>
                <div class="sj m1R"></div>
            </div>
            <ul class="color303030 f33 none" :class="obj['4'].on" ref="select4">
                <li class="p05T p05B borderB p1L" v-for='item in list4' @click="choseRelated(item,'4','5')">{{item.name}}</li>
            </ul>
            <?= $form->field($employment, 'employer_business')->textInput(['class'=>'none', ':value' => 'choseId4'])->label(false) ?>
            <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war4"></div>

            <div class="m1L m1T p1B borderB color656565 flexBox1" @click="showRelated('5','4')">
                <div class="flexBox2">
                    <div class="w140">职位<span class="colorEF7E2E">*</span></div>
                    <span class="colorADADAD">{{choseData5?choseData5:'请选择'}}</span>
                </div>
                <div class="sj m1R"></div>
            </div>
            <ul class="color303030 f33 none" :class="obj['5'].on" ref="select5">
                <li class="p05T p05B borderB p1L" v-for='item in filterlist("5")' @click="choseRelated(item,'5','4')">{{item.name}}</li>
            </ul>
            <?= $form->field($employment, 'occupation')->textInput(['class'=>'none', ':value' => 'choseId5'])->label(false) ?>
            <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war5"></div>

            <div class="flexBox1  m1L m1R m1T p1B borderB none" >
                <div class="color878787 f24 m1R">
                    您或您的任何知悉亲属是否受雇于任何经济
                    交易商，投资顾问，期货佣金商，对冲基金，
                    交易所或其他金融服务公司（既“金融公司”）
                    ，或在该等机构进行过登记？
                </div>
                <div>
                    <input id="switch1" v-model="active" type="checkbox" @click="getSwitch('1',$event)">
                    <label for="switch1" v-model="active"></label>
                    <?= $form->field($employment, 'affiliation')->textInput(['class'=>'none', 'value' => '0'])->label(false) ?>
                </div>
            </div>
            <div class="none" :class="isShow">
                <div class="m1L m1T p1B borderB color656565 flexBox1" @click="show('6')">
                    <div class="flexBox2">
                        <div class="w140">谁受金融公司雇佣<span class="colorEF7E2E">*</span></div>
                        <span class="colorADADAD">{{choseData6?choseData6:'请选择'}}</span>
                    </div>
                    <div class="sj m1R"></div>
                </div>
                <ul class="color303030 f33 none" :class="obj['6'].on" ref="select6">
                    <li class="p05T p05B borderB p1L" v-for='item in list6' @click="chose(item,'6')">{{item.name}}</li>
                </ul>
                <?= $form->field($employment, 'affliation_relationship')->textInput(['class'=>'none', ':value' => 'choseId6'])->label(false) ?>
                <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war6"></div>

                <div class="flexBox1  m1L m1R m1T p1B borderB">
                    <div class="color878787 f24 m1R">
                        需要重复发送声明和确定信息到您公司的合规部门吗？
                    </div>
                    <div>
                        <input checked id="switch2" type="checkbox" @click="getSwitch('2',$event)">
                        <label for="switch2" ></label>
                    </div>
                </div>
                <div :class="isShow2">
                    <div class="m1L m1T p1B borderB color656565 flexBox2">
                        <div class="w140">亲属名称<span class="colorEF7E2E">*</span></div>
                        <?= $form->field($employment, 'affliation_name')->textInput(['class'=>'show valimessage14', 'placeholder'=>'请填写亲属名称', 'value'=>$employment['affliation_name'], '@blur'=>"valimessage('14','亲属名称','input')"])->label(false) ?>
                    </div>
                    <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war14"></div>

                    <div class="m1L m1T p1B borderB color656565 flexBox2">
                        <div class="w140">公司名称<span class="colorEF7E2E">*</span></div>
                        <?= $form->field($employment, 'affliation_company')->textInput(['class'=>'show valimessage15', 'placeholder'=>'请填写公司名称', 'value'=>$employment['affliation_company'], '@blur'=>"valimessage('15','公司名称','input')"])->label(false) ?>
                    </div>
                    <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war15"></div>

                    <div class="m1L m1T p1B borderB color656565 flexBox2">
                        <div class="w140">公司邮箱<span class="colorEF7E2E">*</span></div>
                        <?= $form->field($employment, 'affliation_company_email')->textInput(['class'=>'show valimessage16', 'placeholder'=>'请填写公司邮箱', 'value'=>$employment['affliation_company_email'], '@blur'=>"valimessage('16','公司邮箱','input')"])->label(false) ?>
                    </div>
                    <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war16"></div>

                    <div class="m1L m1T p1B borderB color656565 flexBox2">
                        <div class="w140">公司电话<span class="colorEF7E2E">*</span></div>
                        <?= $form->field($employment, 'affliation_company_phone')->textInput(['class'=>'show valimessage17', 'placeholder'=>'请填写公司电话', 'value'=>$employment['affliation_company_phone'], '@blur'=>"valimessage('17','公司电话','input')"])->label(false) ?>
                    </div>
                    <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war17"></div>

                    <div class="m1L m1T p1B borderB color656565 flexBox2">
                        <div class="w140">公司地址<span class="colorEF7E2E">*</span></div>
                        <?= $form->field($employment, 'affliation_company_address')->textInput(['class'=>'show valimessage18', 'placeholder'=>'请填写公司地址', 'value'=>$employment['affliation_company_address'], '@blur'=>"valimessage('18','公司地址','input')"])->label(false) ?>
                    </div>
                    <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war18"></div>

                    <div class="m1L m1T p1B borderB color656565 flexBox1" @click="show('7')">
                        <div class="flexBox2">
                            <div class="w140">公司所在国家<span class="colorEF7E2E">*</span></div>
                            <span class="colorADADAD">{{choseData7?choseData7:'请选择'}}</span>
                        </div>
                        <div class="sj m1R"></div>
                    </div>
                    <ul class="color303030 f33 none" :class="obj['7'].on" ref="select7">
                        <li class="p05T p05B borderB p1L" v-for='item in list7' @click="chose(item,'7')">{{item.name}}</li>
                    </ul>
                    <?= $form->field($employment, 'affliation_company_country')->textInput(['class'=>'none', ':value' => 'choseId7'])->label(false) ?>
                    <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war7"></div>

                    <div class="m1L m1T p1B borderB color656565 flexBox1" @click="showRelated('8','9')">
                        <div class="flexBox2">
                            <div class="w140">公司所在州/省<span class="colorEF7E2E">*</span></div>
                            <span class="colorADADAD">{{choseData8?choseData8:'请选择'}}</span>
                        </div>
                        <div class="sj m1R"></div>
                    </div>
                    <ul class="color303030 f33 none" :class="obj['8'].on" ref="select8">
                        <li class="p05T p05B borderB p1L" v-for='item in list8' @click="choseRelated(item,'8','9')">{{item.name}}</li>
                    </ul>
                    <?= $form->field($employment, 'affliation_company_state')->textInput(['class'=>'none', ':value' => 'choseId8'])->label(false) ?>
                    <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war8"></div>

                    <div class="m1L m1T p1B borderB color656565 flexBox1" @click="showRelated('9','8')">
                        <div class="flexBox2">
                            <div class="w140">公司所在城市<span class="colorEF7E2E">*</span></div>
                            <span class="colorADADAD">{{choseData9?choseData9:'请选择'}}</span>
                        </div>
                        <div class="sj m1R"></div>
                    </div>
                    <ul class="color303030 f33 none" :class="obj['9'].on" ref="select9">
                        <li class="p05T p05B borderB p1L" v-for='item in filterlist("9")' @click="choseRelated(item,'9','8')">{{item.name}}</li>
                    </ul>
                    <?= $form->field($employment, 'affliation_company_city')->textInput(['class'=>'none', ':value' => 'choseId9'])->label(false) ?>
                    <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war9"></div>


                    <div class="m1L m1T p1B borderB color656565 flexBox2">
                        <div class="w140">公司邮编<span class="colorEF7E2E">*</span></div>
                        <?= $form->field($employment, 'affliation_company_postcode')->textInput(['class'=>'show valimessage19', 'placeholder'=>'请填写公司邮编', 'value'=>$employment['affliation_company_postcode'], '@blur'=>"valimessage('19','公司邮编','input')"])->label(false) ?>
                    </div>
                    <div class="colorFF7F24 p1L p05T p05B f24 bgfef1e6 none war19"></div>
                </div>
            </div>
        </div>

        <div class="flexBox1 m1L m1R m1T wBtnBox m2B" :class="showfixed">
            <div class="prevBtn borderCACACA color000 bgffffff cenetr radius20px f33 p05T p05B relative">
                上一步
                <a href="<?= Url::to(['personinfo', 'Customer_id' => $Customer_id])?>" class="fileInput"></a>
            </div>
            <div class="nextBtn f33 bgEF7E2E colorFFF cenetr  p05T p05B radius20px" @click="nextsubmit()">
                下一步
                <input type="submit" class="divHide" id="next">
            </div>
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
            activeEM:'<?=$data['employStatus']?>'=='受雇' ? true : false,
            active:false,
            active2:true,
            activeFixed:'<?=$data['employStatus']?>'=='受雇' ? false : true,
            list0:<?=$employStatus?>,
            list1:[{'name':'澳大利亚', 'value':'AUS'}],//,{'name':'美国', 'value':'USA'},{'name':'中国', 'value':'CHN'}
            list2:<?=$state?>,
            list3:<?=$city?>,
            list4:<?=$embs?>,
            list5:<?=$emoc?>,
            list6:<?=$rel?>,
            list7:[{'name':'澳大利亚', 'value':'AUS'}],//,{'name':'美国', 'value':'USA'},{'name':'中国', 'value':'CHN'}
            list8:<?=$state?>,
            list9:<?=$city?>,
            choseData0:'<?=$data['employStatus']?>',
            choseData1:'<?=$employment['country']=='USA' ? '美国' : ($employment['country']=='CHN' ? '中国' : '澳大利亚')?>',
            choseData2:'<?=($data['state_cn']!='' ? $data['state_cn'] : '请选择')?>',
            choseData3:'<?=($data['city_cn']!='' ? $data['city_cn'] : '请选择')?>',
            choseData4:'<?=($data['employer_business']!='' ? $data['employer_business'] : '请选择')?>',
            choseData5:'<?=($data['occupation']!='' ? $data['occupation'] : '请选择')?>',
            choseData6:'<?=($data['rel']!='' ? $data['rel'] : '请选择')?>',
            choseData7:'<?=$employment['affliation_company_country']=='USA' ? '美国' : ($employment['affliation_company_country']=='CHN' ? '中国' : '澳大利亚')?>',
            choseData8:'<?=($data['aff_state_cn']!='' ? $data['aff_state_cn'] : '请选择')?>',
            choseData9:'<?=($data['aff_city_cn']!='' ? $data['aff_city_cn'] : '请选择')?>',
            choseId0:'<?=($candidate['employment_type']!='' ? $candidate['employment_type'] : '')?>',
            choseId1:'<?=$employment['country']!='' ? $employment['country'] : 'AUS'?>',
            choseId2:'<?=($employment['state']!='' ? $employment['state'] : '')?>',
            choseId3:'<?=($employment['city']!='' ? $employment['city'] : '')?>',
            choseId4:'<?=($employment['employer_business']!='' ? $employment['employer_business'] : '')?>',
            choseId5:'<?=($employment['occupation']!='' ? $employment['occupation'] : '')?>',
            choseId6:'<?=($employment['affliation_relationship']!='' ? $employment['affliation_relationship'] : '')?>',
            choseId7:'<?=$employment['affliation_company_country']!='' ? $employment['affliation_company_country'] : 'AUS'?>',
            choseId8:'<?=($employment['affliation_company_state']!='' ? $employment['affliation_company_state'] : '')?>',
            choseId9:'<?=($employment['affliation_company_city']!='' ? $employment['affliation_company_city'] : '')?>',
            choseSwitch:'0',
            obj:[
                {on:'',switch:false},{on:'',switch:false},{on:'',switch:false},
                {on:'',switch:false},{on:'',switch:false},{on:'',switch:false},
                {on:'',switch:false},{on:'',switch:false},{on:'',switch:false},{on:'',switch:false},
            ],
        },
        computed:{
            isShow:function(){
                return this.active?'show':''
            },
            isShow2:function(){
                return this.active2?'show':'none'
            },
            isShowEM:function(){
                return this.activeEM?'show':'none'
            },
            showfixed:function(){//就业状况
                return this.activeFixed?'fixed':''
            },
            filterlist() {//关联下拉过滤
                return function(index){
                    var i = parseInt(index)-1;
                    var id = this['choseId'+i];
                    return this['list'+index].filter(function (list) {
                        if(id!=''){
                            return list.id == id;
                        }else{
                            return true;
                        }
                    });
                }
            }
        },
        methods:{
            chose:function(data,index){
                if(index=='0'){//就业状况
                    if(data.name == '受雇'){
                        this.activeEM = true;
                        this.activeFixed = false;
                    }else{
                        this.activeEM = false;
                        this.activeFixed = true;
                    }
                }
                this['choseData'+index]=data.name
                this['choseId'+index]=data.value
                this.show(index);
            },
            choseRelated:function(data,index,otherindex){//关联下拉点击事件
                if(index < otherindex){
                    this['choseData'+otherindex]='请选择'
                }
                if(index=='2' || index=='8'){
                    this['choseId'+index]=data.id
                }else{
                    this['choseId'+index]=data.value
                }
                this['choseData'+index]=data.name
                this.showRelated(index,otherindex);
            },
            show:function(index){
                this.obj[index].switch=!this.obj[index].switch
                this.obj[index].switch?this.obj[index].on='show':this.obj[index].on=''
                this.obj[index].switch?this.on='show':this.on=''
            },
            showRelated:function(index,otherindex){//关联下拉表显示
                if(this.obj[otherindex].switch){
                    this.show(otherindex);
                }
                this.show(index);
            },
            getSwitch:function(id,ev){
                if(id=='1'&&ev.target.checked){
                    this.active=true;
                    this.choseSwitch = '1';
                }else if(id=='1'&&ev.target.checked==false){
                    this.active=false;
                    this.choseSwitch = '0';
                }else if(id=='2'&&ev.target.checked){
                    this.active2=true
                }else if(id=='2'&&ev.target.checked==false){
                    this.active2=false
                }
            },
            valiselect:function(index,title,tab){//下拉框验证
                var value = this['choseId'+index];
                if(value.trim()!=''&&value.trim()!='请选择'){
                    //通过验证
                    $(".war"+index).hide();
                    return true;
                }else{
                    $(".war"+index).text("请选择"+title);
                    $(".war"+index).show();
                    return false;
                }
            },
            valiinput:function(index,title){//输入框验证
                var value = $(".valimessage"+index).val();
                var reg = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
                var reg2 = /^[0-9]*$/;
                if(value.trim() != ""){
                    if(index=='16' && !reg.test(value)){
                        $(".war"+index).text(title+"格式不正确");
                        $(".war"+index).show();
                        return false;
                    }else if((index=='13' || index=='19' || index=='17') && !reg2.test(value)){
                        $(".war"+index).text(title+"必须是数字");
                        $(".war"+index).show();
                        return false;
                    }else if(index=='18' && $(".valimessage12").val() == value){
                        $(".war"+index).text("雇主的地址不能和申请人的居住地址一致");
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
            },
            valimessage:function(index,title,tab){
                var i = parseInt(index);
                var vali1 = '受雇';
                var employStatus = this['choseData0'];
                var switch1 = $("#switch1").is(':checked');
                var switch2 = $("#switch2").is(':checked');
                //亲属关系，公司所在国家、州、城市
                if(i==0 || (i==6 && employStatus==vali1 && switch1)
                    || (i<6 && i>=1 && employStatus==vali1)
                    || (i<10 && i>6 && employStatus==vali1 && switch1 && switch2)){
                    return this.valiselect(index,title,tab);
                }else if((i>=11 && i<14 && employStatus==vali1)
                    || (i>=14 && i<=19 && employStatus==vali1 && switch1 && switch2)){
                    return this.valiinput(index,title);
                }else{
                    return true;
                }
            },
            nextsubmit:function(){
                if(this.valimessage('0','就业状况','select') && this.valimessage('11','雇佣单位','input') && this.valimessage('1','国家/地区','select')
                    && this.valimessage('2','签发州/省','select') && this.valimessage('3','城市','select') && this.valimessage('12','地址','input')
                    && this.valimessage('13','邮编','input') && this.valimessage('4','商业性质','select') && this.valimessage('5','职位','select')
                    && this.valimessage('6','亲属关系','select')
                    && this.valimessage('14','亲属名称','input') && this.valimessage('15','公司名称','input') && this.valimessage('16','公司邮箱','input')
                    && this.valimessage('17','公司电话','input') && this.valimessage('18','公司地址','input') && this.valimessage('7','公司所在国家','select')
                    && this.valimessage('8','公司所在州/省','select') && this.valimessage('9','公司所在城市','select') && this.valimessage('19','邮编','input')){

                    $('#next').trigger('click');
                }
            }
        }
    });
</script>
