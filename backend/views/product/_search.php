<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
/** @var $pageSize integer */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id' => 'product-search-form'
    ]); ?>

    <?php // echo $form->field($model, 'product_id') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'rank') ?>

    <?php // echo $form->field($model, 'isActive') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-inline m-b-md">
        <?= Html::label('Show ', null, ['class' => 'control-label fw-400']) ?>
        <?= Html::dropDownList('pageSize', $pageSize,
            [10 => '10', 20 => '20', 50 => '50', 100 => '100'],
            ['id' => 'select-page-size', 'class' => 'form-control inline-block text-center fw-600', 'style' => 'max-width:80px;min-width:80px;height:33px;']) ?>
        <?= Html::label('products', null, ['class' => 'control-label fw-400']) ?>
    </div>

    <!--<div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['id'=> 'clear-btn', 'class' => 'btn btn-outline-secondary']) ?>
    </div>-->

    <?php ActiveForm::end(); ?>

    <?php

    $this->registerJs("
$('#product-search-form').on('change', '#select-page-size', function(event){
    $('#product-search-form').submit();
    event.preventDefault();
});
$('#product-search-form').on('click', '#clear-btn', function(event){
    $('#product-search-form input').val('');
    $('#product-search-form select').val('');
    $('#product-search-form').submit();
    event.preventDefault();
});
");

    ?>

</div>
