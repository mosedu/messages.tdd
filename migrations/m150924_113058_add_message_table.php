<?php

use yii\db\Schema;
use yii\db\Migration;

class m150924_113058_add_message_table extends Migration
{
    public function up()
    {
        $tableOptionsMyISAM = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM';

        $this->createTable('{{%message}}', [
            'msg_id' => Schema::TYPE_PK . ' Comment \'Номер\'',
            'msg_type' => Schema::TYPE_SMALLINT . ' Not NULL Default 0 Comment \'Тип\'',
            'msg_dep_id' => Schema::TYPE_INTEGER . ' Not NULL Default 0 Comment \'Отдел\'',
            'msg_created' => Schema::TYPE_DATETIME . ' NOT NULL Comment \'Поступило\'',
            'msg_person' => Schema::TYPE_STRING . ' NOT NULL Default \'\' Comment \'ФИО автора\'',
            'msg_email' => Schema::TYPE_STRING . ' NOT NULL Default \'\' Comment \'Email автора\'',
            'msg_phone' => Schema::TYPE_STRING . ' NOT NULL Default \'\' Comment \'Телефон автора\'',
            'msg_subject' => Schema::TYPE_STRING . ' NOT NULL Default \'\' Comment \'Тема\'',
            'msg_child' => Schema::TYPE_STRING . ' NOT NULL Default \'\' Comment \'ФИО ребенка\'',
            'msg_child_birth' => Schema::TYPE_DATE . ' Comment \'Дата рождения ребенка\'',
            'msg_ekis_id' => Schema::TYPE_STRING . ' Comment \'ЕКИС ID организации\'',
            'msg_text' => Schema::TYPE_TEXT . ' Comment \'Текст\'',
            'msg_user_id' => Schema::TYPE_INTEGER . ' Comment \'Ответственный\'',
            'msg_user_setted' => Schema::TYPE_DATETIME . ' Comment \'Назначен ответственный\'',
            'msg_answer_period' => Schema::TYPE_DATETIME . ' Comment \'Контрольный срок ответа\'',
            'msg_answer' => Schema::TYPE_TEXT . ' Comment \'Ответ\'',
            'msg_answer_time' => Schema::TYPE_DATETIME . ' Comment \'Дата ответа\'',
            'msg_comment' => Schema::TYPE_TEXT . ' Comment \'Примечание\'',
            'msg_status' => Schema::TYPE_SMALLINT . ' Not NULL Default 0 Comment \'Статус\'',
            'msg_talk_start' => Schema::TYPE_DATETIME . ' Comment \'Начало разговора\'',
            'msg_talk_finish' => Schema::TYPE_DATETIME . ' Comment \'Окончание разговора\'',

        ], $tableOptionsMyISAM);

        $this->refreshCache();
    }

    public function down()
    {
        $this->dropTable('{{%message}}');
        $this->refreshCache();
        return true;
    }

    public function refreshCache()
    {
        Yii::$app->db->schema->refresh();
        Yii::$app->db->schema->getTableSchemas();
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
