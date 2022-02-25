<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description',
    [
            'inputOptions' => [
                'class' => [
                    'widget' => 'm-0',
                ],
                'data-plugin' => 'summernote',
                'data-options' => '{height: 250}'
            ]
    ]
    )->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'isActive',[
        'checkTemplate' => '<div class="custom-control checkbox checkbox-primary custom-checkbox">{input}{label}{error}{hint}</div>',
    ])->label('Active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
