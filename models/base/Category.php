<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace kittyfamous\webmanager\models\base;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
/**
 * This is the base-model class for table "category".
 *
 * @property integer $id
 * @property integer $root
 * @property integer $lft
 * @property integer $rgt
 * @property integer $level
 * @property string $category_zh
 * @property string $category_en
 * @property string $category_fr
 * @property string $category_ru
 * @property string $category_es
 * @property integer $created_at
 * @property integer $created_by
 * @property string $aliasModel
 */
abstract class Category extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'updatedByAttribute' => false,
            ],
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
        ];
    }

    public function rules()
    {
        return [
            [['category_zh'], 'required'],
            [['root', 'lft', 'rgt', 'level', 'created_at', 'created_by'], 'integer'],
            [['category_zh', 'category_en', 'category_fr', 'category_ru', 'category_es'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'root' => 'Root',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'level' => 'Level',
            'category_zh' => '分类名称-中文',
            'category_en' => '分类名称-英语',
            'category_fr' => '分类名称-法语',
            'category_ru' => '分类名称-俄语',
            'category_es' => '分类名称-西班牙语',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return array_merge(parent::attributeHints(), [
            'category_zh' => '分类名称-中文',
            'category_en' => '分类名称-英语',
            'category_fr' => '分类名称-法语',
            'category_ru' => '分类名称-俄语',
            'category_es' => '分类名称-西班牙语',
        ]);
    }




}
