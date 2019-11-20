<?php

use yii\db\Migration;

/**
 * Class m191117_062825_settings
 */
class m191117_062825_settings extends Migration
{
    const FIELD_TYPE = ['text' => 1, 'textarea' => 2, 'checkbox' => 3, 'radio' => 4, 'select' => 5];
    const STATUS     = ['GENERAL' => 0, 'MAIN' => 1];
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%setting}}', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(100)->notNull(),
            'value'      => $this->text(),
            'required'   => $this->boolean()->notNull(),
            'status'     => $this->tinyInteger(4)->notNull(),
            'domain_id'  => $this->integer(),
            'lang_id'    => $this->integer(),
            'field_type' => $this->tinyInteger(4)->notNull()
        ]);
        
        $this->createTable('{{%domain}}', [
            'id'     => $this->primaryKey(),
            'domain' => $this->string(255)->notNull()->unique(),
            'main'   => $this->boolean()->notNull()
        ]);
        
        $this->createTable('{{%language}}', [
            'id'         => $this->primaryKey(),
            'code'       => $this->char(2)->notNull()->unique(),
            'code_local' => $this->string(32)->notNull(),
            'name'       => $this->string(100)->notNull(),
            'status'     => $this->tinyInteger(2)->notNull(),
        ]);
        
        $this->createIndex('idx-language-code', '{{%language}}', 'code');
        
        $this->createIndex('idx-domain-domain_id', '{{%setting}}', 'domain_id');
        $this->createIndex('idx-domain-lang_id', '{{%setting}}', 'lang_id');
        
        $this->addForeignKey('fk-setting-domain_id', '{{%setting}}', 'domain_id', '{{%domain}}', 'id');
        $this->addForeignKey('fk-language-lang_id', '{{%setting}}', 'lang_id', '{{%language}}', 'id');
        
        $this->baseFill();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191117_062825_settings cannot be reverted.\n";
        return false;
    }
    
    private function baseFill()
    {
        $this->batchInsert('{{%domain}}', ['domain', 'main'], [
           ['main', true] 
        ]);
        
        $this->batchInsert('{{%language}}', ['code', 'code_local', 'name', 'status'], [
            ['en', 'en-US', 'english', 1],
            ['ru', 'ru-RU', 'russian', 0]
        ]);
        
        $this->batchInsert(
            '{{%setting}}', 
            ['name', 'value', 'required', 'status', 'domain_id', 'lang_id', 'field_type'], 
            [
                ['disconnected', 'false', false, self::STATUS['GENERAL'], null, null, self::FIELD_TYPE['checkbox']],
                ['main_page', 1, true, self::STATUS['GENERAL'], null, null, self::FIELD_TYPE['select']],
                
                ['disconnected', 'false', false, self::STATUS['MAIN'], 1, null, self::FIELD_TYPE['checkbox']],
                ['main_page', 1, true, self::STATUS['MAIN'], 1, null, self::FIELD_TYPE['select']],
            ]);
    }
}