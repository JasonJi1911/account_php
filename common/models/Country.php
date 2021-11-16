<?php
namespace common\models;

use yii\db\ActiveRecord;

/**
 * Phone model
 *
 * @property string $state_en
 * @property string $state_cn
 * @property string $state_code
 * @property string $city_en
 * @property string $city_cn
 */

class Country extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%country}}';
    }
}