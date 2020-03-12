<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kittyfamous\webmanager\models\Category;

/* @var $this yii\web\View */
/* @var $this kittyfamous\webmanager\models\Category */
/* @var $form yii\widgets\ActiveForm */
if(!$model->isNewRecord){
    $parent=$model->parent()->one();
}
// \yii\helpers\VarDumper::dump($model->getDropDownList(),5,true);die;
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php if(!$model->isNewRecord && isset($parent)): ?>
        <?php $model->parent=$parent->id; ?>
    <?php endif ?>
    <?= $form->field($model,'parent')->dropDownList($model->getDropDownList(),['prompt'=>'请选择父节点']); ?>
    <?= $form->field($model, 'channel')->textInput(['maxlength' => 255]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('common/app', 'Create') : Yii::t('common/app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
