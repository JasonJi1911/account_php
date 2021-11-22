<?php

namespace common\metronic\widgets;

use common\helpers\OssHelper;
use common\helpers\OssUrlHelper;
use yii\helpers\Html;
use common\metronic\assets\DatePickerAsset;

class ActiveField extends \yii\widgets\ActiveField
{
    /**
     * @var string
     */
    // public $template = "{label}\n{input}\n";
    /**
     * {@inheritdoc}
     */
    public $labelOptions = ['class' => 'col-md-3 control-label'];
    /**
     * @var array
     */
    public $hintOptions = ['class' => 'help-block'];
    /**
     * @var array
     */
    public $wrapperOptions = ['class' => 'col-md-5'];

    /**
     * @inheritdoc
     */
    public function render($content = null)
    {
        if ($content === null) {
            if (!isset($this->parts['{input}'])) {
                $this->textInput();
            }
            if (!isset($this->parts['{label}'])) {
                $this->label();
            }
            if (!isset($this->parts['{error}'])) {
                $this->error();
            }
            if (!isset($this->parts['{hint}'])) {
                $this->hint(null);
            }

            $wrapperContent  = $this->parts['{input}'];

            if (!$this->model->hasErrors($this->attribute) && strip_tags($this->parts['{hint}'])) {
                $wrapperContent .= $this->parts['{hint}'];
            } else {
                $wrapperContent .= $this->parts['{error}'];
            }

            $content = $this->parts['{label}'] . $wrapperContent;

        } elseif (!is_string($content)) {
            $content = call_user_func($content, $this);
        }

        return $content;
    }

    /**
     * 图片上传控件
     */
    public function imageUpload($options = [])
    {
        \common\metronic\assets\FileInputAsset::register($this->form->getView());

        $fileType = isset($options['file_type']) ? $options['file_type'] : '1';
        if ($fileType == 2) {
            $fileName = '文件';
        } else {
            $fileName = '图片';
        }

        if (isset($options['width'])) {
            $width = $options['width'];
            unset($options['width']);
        } else {
            $width = 200;
        }

        if (isset($options['height'])) {
            $height = $options['height'];
            unset($options['height']);
        } else {
            $height = 150;
        }

        $this->form->options['enctype'] = 'multipart/form-data';
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);

        $html = '<div class="m15L m15R radius20px bgF9F9F9 m1T cenetr">';

        $value = $this->model->getAttribute($this->attribute);
        if ($value && ($value instanceof OssUrlHelper)) { // 有值并且要是图片对象
            if (!($value instanceof OssUrlHelper)) {
                $value = OssUrlHelper::set($value);
            }
            $thumb = $value;
            $imgUrl = $thumb->resize($width, $height);
            $html .= "<img src='" . $imgUrl . "' :src='imgUrl' class='w100' onerror='this.src=\"/img/icon_7.png\"'/>";

            if (!$imgUrl->__toString())
                $html .= '<div class="cenetr textpos">证件正面照片</div>';
            $html .= '</div>';
        }

        $html .= '<div class="fon500 bgF9F9F9 H80 linH80 cenetr m15L m15R radius14px m05T pos-relative">从相册中选择';
        $html .=      Html::activeFileInput($this->model, $this->attribute, $options);
        $html .= '</div>';

        $this->parts['{input}'] = $html;

        return $this;
    }

    public function MySwitch($options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        $html = '<div>';
        $html .= Html::activeCheckbox($this->model, $this->attribute, $options);
        $html .= '<label for="'.$options['id'].'"></label>';
        $html .= '</div>';

        $this->parts['{input}'] = $html;
        return $this;
    }

    /**
     * 日期控件
     */
    public function datePickerInput($options = [])
    {
        DatePickerAsset::register($this->form->getView());
        Html::addCssClass($options, 'form-control date-picker');
        return parent::textInput($options)->wrapper(['width' => 3]);
    }

    /**
     * 日期时间控件
     */
    public function datetimePickerInput($options = [])
    {
        DateTimePickerAsset::register($this->form->getView());

        Html::addCssClass($options, 'datetime-picker');
        return parent::textInput($options)->wrapper(['width' => 3]);
    }
}