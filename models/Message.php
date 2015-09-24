<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%message}}".
 *
 * @property integer $msg_id
 * @property integer $msg_type
 * @property integer $msg_dep_id
 * @property string $msg_created
 * @property string $msg_person
 * @property string $msg_email
 * @property string $msg_phone
 * @property string $msg_subject
 * @property string $msg_child
 * @property string $msg_child_birth
 * @property string $msg_ekis_id
 * @property string $msg_text
 * @property integer $msg_user_id
 * @property string $msg_user_setted
 * @property string $msg_answer_period
 * @property string $msg_answer
 * @property string $msg_answer_time
 * @property string $msg_comment
 * @property integer $msg_status
 * @property string $msg_talk_start
 * @property string $msg_talk_finish
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['msg_type', 'msg_dep_id', 'msg_user_id', 'msg_status'], 'integer'],
            [['msg_created'], 'required'],
            [['msg_created', 'msg_child_birth', 'msg_user_setted', 'msg_answer_period', 'msg_answer_time', 'msg_talk_start', 'msg_talk_finish'], 'safe'],
            [['msg_text', 'msg_answer', 'msg_comment'], 'string'],
            [['msg_person', 'msg_email', 'msg_phone', 'msg_subject', 'msg_child', 'msg_ekis_id'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'msg_id' => 'Номер',
            'msg_type' => 'Тип',
            'msg_dep_id' => 'Отдел',
            'msg_created' => 'Поступило',
            'msg_person' => 'ФИО автора',
            'msg_email' => 'Email автора',
            'msg_phone' => 'Телефон автора',
            'msg_subject' => 'Тема',
            'msg_child' => 'ФИО ребенка',
            'msg_child_birth' => 'Дата рождения ребенка',
            'msg_ekis_id' => 'ЕКИС ID организации',
            'msg_text' => 'Текст',
            'msg_user_id' => 'Ответственный',
            'msg_user_setted' => 'Назначен ответственный',
            'msg_answer_period' => 'Контрольный срок ответа',
            'msg_answer' => 'Ответ',
            'msg_answer_time' => 'Дата ответа',
            'msg_comment' => 'Примечание',
            'msg_status' => 'Статус',
            'msg_talk_start' => 'Начало разговора',
            'msg_talk_finish' => 'Окончание разговора',
        ];
    }
}
