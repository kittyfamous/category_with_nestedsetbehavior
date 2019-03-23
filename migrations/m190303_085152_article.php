<?php

use yii\db\Migration;

/**
 * Class m190303_085152_category
 */
class m190303_085152_category extends Migration
{
    const TBL_CATEGORY = "{{%category}}";   //多语言版无限分类表

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::TBL_CATEGORY,[
            'id' => $this->primaryKey(),
            'root' => $this->smallInteger()->notNull(),
            'lft' => $this->smallInteger()->notNull(),
            'rgt' => $this->smallInteger()->notNull(),
            'level' => $this->smallInteger()->notNull(),
            'category_zh' => $this->string()->notNull()->defaultValue("")->comment('分类名称-中文'),
            'category_en' => $this->string()->notNull()->defaultValue("")->comment('分类名称-英语'),
            'category_fr' => $this->string()->notNull()->defaultValue("")->comment('分类名称-法语'),
            'category_ru' => $this->string()->notNull()->defaultValue("")->comment('分类名称-俄语'),
            'category_es' => $this->string()->notNull()->defaultValue("")->comment('分类名称-西班牙语'),
//            'summary' => $this->string()->notNull()->defaultValue("")->comment('分类摘要'),
            'created_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
        ],$tableOptions);

    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190303_085152_category cannot be reverted.\n";
//        $bool = $this->dropTable(self::TBL_ARTICLE);
//        $bool = $bool && $this->dropTable(self::TBL_CATEGORY);
//        return $bool;

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190303_085152_category cannot be reverted.\n";

        return false;
    }
    */
}
