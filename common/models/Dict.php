<?php
namespace common\models;

use yii\db\ActiveRecord;

/**
 * Dict model
 *
 * @property string $dkey
 * @property string $dvalue
 * @property string $type
 */
class Dict extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%dict}}';
    }

}