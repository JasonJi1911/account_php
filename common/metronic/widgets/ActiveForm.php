<?php

namespace common\metronic\widgets;

use yii\helpers\Html;

/**
 * 表单控件
 *
 */
class ActiveForm extends \yii\widgets\ActiveForm
{
    /**
     * {@inheritdoc}
     */
    public $options = ['class' => 'form form-horizontal'];
    /**
     * {@inheritdoc}
     */
    public $fieldClass = 'common\metronic\widgets\ActiveField';

    public static $buttonName = '保存';

    /**
     * {@inheritdoc}
     */
    public static function begin($config = [])
    {
        $widget = parent::begin($config);

//        echo Html::beginTag('div', ['class' => 'form-body']) . "\n";

        return $widget;
    }

    /**
     * {@inheritdoc}
     */
    public static function end()
    {
//        echo Html::endTag('div') . "\n";
//
//        $buttons = [
//            Html::submitButton(self::$buttonName, ['class' => 'btn green']),
//            Html::button('返回', ['class' => 'btn default', 'onclick' => 'history.back()']),
//        ];
//
//        echo Html::tag('div', Html::tag('div', Html::tag('div', join("\n", $buttons), ['class' => 'col-md-offset-3 col-md-9']), ['class' => 'row']), ['class' => 'form-actions']);

        parent::end();
    }
}
