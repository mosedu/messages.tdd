<?php

namespace app\models;

use Yii;

use app\models\Depusers;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%department}}".
 *
 * @property integer $dep_id
 * @property string $dep_title
 * @property integer $dep_active
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%department}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dep_title'], 'required', ],
            [['dep_active'], 'integer'],
            [['dep_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dep_id' => 'ID',
            'dep_title' => 'Название',
            'dep_active' => 'Активный',
        ];
    }

    public function getUsers() {
        return $this->hasMany(
            Depusers::className(),
            ['dus_dep_id' => 'dep_id']
        );
    }

    /**
     * @return static[]
     */
    public static function getAll() {
        return self::findAll(['dep_active' => 1]);
    }

    /**
     * @return array
     */
    public static function getList() {
        return ArrayHelper::map(self::getAll(), 'dep_id', 'dep_title');
    }
}
