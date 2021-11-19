<?php

namespace common\models;
use yii\db\ActiveRecord;

/**
 * Candidate model
 *
 * @property integer $Customer_id
 * @property string $percentage
 * @property string $is_used_for_funds
 * @property string $source_type
 * @property string $description
 */

class Wealth extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%wealth}}';
    }
}