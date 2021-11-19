<?php
namespace common\models;

use yii\db\ActiveRecord;

/**
 * employment_business model
 *
 * @property string $id
 * @property string $name
 * @property string $text
 * @property string $occupation
 * @property string $occupation_cn
 */
class EmployerBusiness extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%employer_business}}';
    }
}