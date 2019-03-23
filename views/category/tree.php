<?php
use yii\helpers\Html;
use kittyfamous\webmanager\models\Category;

$this->title=Yii::t('app','category Tree');
$this->params['breadcrumbs'][]=$this->title;

?>
<div class="category-index">
    <h1><?php echo Html::encode($this->title); ?></h1>
    <p><?php echo Html::a(Yii::t('common/app','Create Category'),['create'],['class'=>'btn btn-success']); ?></p>
<h1>category/tree</h1>

<?php
    Category::renderTree();
?>
</div>
    <style>
      .category-index li{
          margin-left:50px;
      }
    </style>
