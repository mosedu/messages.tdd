<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%depusers}}".
 *
 * @property integer $dus_id
 * @property integer $dus_us_id
 * @property integer $dus_dep_id
 */
class Depusers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%depusers}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dus_us_id', 'dus_dep_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dus_id' => 'Dus ID',
            'dus_us_id' => 'Пользователь',
            'dus_dep_id' => 'Отдел',
        ];
    }
}
