<?php

namespace kittyfamous\webmanager\models;

use Yii;
use kittyfamous\webmanager\models\base\Category as BaseCategory;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kittyfamous\webmanager\components\NestedSetBehavior;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "category".
 */
class Category extends BaseCategory
{

    public $parent;
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                [
                    'class' => NestedSetBehavior::className(),
                    'hasManyRoots' => true
                ],
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                [['parent'], 'integer'],
            ]
        );
    }

    /**
     * {@inheritdoc}
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

    //生成带optgroup的dropdown
    public static function getOptgroupDropDownList($id = 'root'){
        $category = new Category;
        if($id == 'root')
            $categories = $category->roots()->all();
        else
            $categories = Category::findOne($id)->children()->all();
        $items = [];
        foreach ($categories as $key => $value){
            $children = $value->descendants()->all();
            foreach ($children as $child) {
                $items[$value->category_zh][$child->id] = $child->category_zh;
            }
        }
        return $items;
    }

    //生成下拉列表 key=>value
    public static function getDropDownList($id = 'root'){
        $category=new Category;
        if($id == 'root')
            $categories=$category->roots()->all();
        else
            $categories=Category::findOne($id)->children()->all();
        $level=0;
//        $items[0]=Yii::t('common/app','Please select the parent node');
        $items = [];
        foreach ($categories as $key => $value) {
            $items[$value->attributes['id']]=$value->attributes['category_zh'];
            $children=$value->descendants()->all();
            foreach ($children as $child) {
                $string='  ';
                $string.=str_repeat('│  ', $child->level-$level-1);
                if($child->isLeaf() && !$child->next()->one()){
                    $string.='└';
                }else{
                    $string.='├';
                }
                $string.='─'.$child->category_zh;
                $items[$child->id]=$string;
            }
        }
        return $items;
    }
    //生成树形结构 使用场景后台
    public static function renderTree(){
        $c=new Category();
        $roots=$c->roots()->all();
        foreach ($roots as $key => $root) {
            $categories=Category::find()->where(['root'=>$root->id])->orderBy('lft')->all();
            $level=0;
            foreach ($categories as $key => $category) {
                // echo '<br>c->level'.$category->level.' level:'.$level.'<br>';
                if($category->level==$level){
                    echo Html::endTag('li')."\n";
                }else if($category->level>$level){
                    echo Html::beginTag('ul')."\n";
                }else{
                    echo Html::endTag('li')."\n";
                    for($i=$level-$category->level;$i;$i--){
                        echo Html::endTag('ul')."\n";
                        echo Html::endTag('li')."\n";
                    }
                }
                echo Html::beginTag('li');
                echo Html::encode($category->category_zh).' <span class="text-muted">(';
                echo Html::encode($category->id).')</span>  ';
                echo Html::a('<span class="glyphicon glyphicon-arrow-up"></span>',['move','id'=>$category->id,'updown'=>'up']).'  ';
                echo Html::a('<span class="glyphicon glyphicon-arrow-down"></span>',['move','id'=>$category->id,'updown'=>'down']).'  ';
                echo Html::a('<span class="glyphicon glyphicon-eye-open"></span>',['view','id'=>$category->id]).'  ';
                echo Html::a('<span class="glyphicon glyphicon-pencil"></span>',['update','id'=>$category->id]).'  ';
                echo Html::a('<span class="glyphicon glyphicon-trash"></span>',['delete','id'=>$category->id],[
                    'title'=>Yii::t('common/app','Delete'),
                    'data-confirm'=>Yii::t('yii','Are you sure you want to delete this item?'),
                    'data-method'=>'post',
                    'data-pjax'=>'0',
                ]);
                $level=$category->level;
            }
            for($i=$level;$i;$i--){
                echo Html::endTag('li')."\n";
                echo Html::endTag('ul')."\n";
            }
        }
    }
    //获取 注册用户可以发贴的类型
    public static function getCategory($id = 1){
//        $data =  Category::find()->where(['parent'=>$parent])->orderBy('lft')->asArray()->all();
        $data = Category::findOne($id);
        $row = $data->children()->all();
        return ArrayHelper::map($row,'id','category_zh');
    }
    //发贴rule规则时使用 角色用户
    public static function getLoginUserArticleCategory($id = 3){
        $data = Category::findOne($id);
        $row = $data->children()->select('id')->column();
        return $row;
    }
    //发贴rule规则时使用 角色管理员
    public static function getAdminArticleCategory($id = 2){
        $data = Category::findOne($id);
        $row = $data->children()->select('id')->column();
        return array_merge($row,self::getLoginUserArticleCategory());
    }

}
