<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
?>
<h1>category/tree</h1>

<div class="category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
