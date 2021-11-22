<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Candidate model
 *
 * @property integer $Customer_id
 * @property string $controller
 * @property string $exchange_code
 * @property string $political
 * @property string $political_title
 * @property string $political_person_name
 * @property string $political_organization
 * @property string $political_country
 */

class Regulatory extends ActiveRecord
{
    public function rules()
    {
        return [
            [['controller', 'political'], 'string'],
            [['exchange_code'], 'validateController', 'skipOnEmpty' => false],
            [
                ['political_title', 'political_person_name',
                'political_organization', 'political_country']
                , 'validatePolitical'
                , 'skipOnEmpty' => false
            ],
//            [['political_person_name'], 'required', 'message' => '政府雇员的姓名不能为空'],
//            [['political_organization'], 'required', 'message' => '政府单位不能为空'],
//            [['political_country'], 'required', 'message' => '政府所在国家不能为空'],
        ];
    }

    public function validateController($attribute, $params)
    {
        if ($this->controller == 0)
            return;

        if (!$this->$attribute)
            $this->addError($attribute, '公司代码不能为空');
    }

    public function validatePolitical($attribute, $params)
    {
        if ($this->political == 0)
            return;

        if (!$this->$attribute)
        {
            switch ($attribute)
            {
                case 'political_title':
                    $this->addError($attribute, '政府职位不能为空');
                    break;
                case 'political_person_name':
                    $this->addError($attribute, '政府雇员的姓名不能为空');
                    break;
                case 'political_organization':
                    $this->addError($attribute, '政府单位不能为空');
                    break;
                case 'political_country':
                    $this->addError($attribute, '政府所在国家不能为空');
                    break;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%regulatory}}';
    }

    /**
     * {@inheritdoc}
     */
    public static function ClassName()
    {
        return 'Regulatory';
    }
}