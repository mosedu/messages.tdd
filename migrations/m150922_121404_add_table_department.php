<?php

use yii\db\Schema;
use yii\db\Migration;

class m150922_121404_add_table_department extends Migration
{
    public function up()
    {
        $tableOptionsMyISAM = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM';

        $this->createTable('{{%department}}', [
            'dep_id' => Schema::TYPE_PK,
            'dep_title' => Schema::TYPE_STRING . ' Comment \'Название\'',
            'dep_active' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1 Comment \'Активный\'',
        ], $tableOptionsMyISAM);


        $this->createTable('{{%depusers}}', [
            'dus_id' => Schema::TYPE_PK,
            'dus_us_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0 Comment \'Пользователь\'',
            'dus_dep_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0 Comment \'Отдел\'',
        ], $tableOptionsMyISAM);

    }

    public function down()
    {
        $this->dropTable('{{%department}}');
        $this->dropTable('{{%depusers}}');

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
