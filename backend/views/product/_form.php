<?php

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="product-form">

    <div class="row">
        <div class="col-md-9">
            <div class="widget">
                <header class="widget-header">
                    <h4 class="text-muted m-0">Product</h4>
                </header><!-- .widget-header -->
                <hr class="widget-separator m-0">
                <div class="widget-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'description',
                        [
                            'inputOptions' => [
                                'class' => [
                                    'widget' => 'm-0',
                                ],
                                'data-plugin' => 'summernote',
                                'data-options' => '{height: 420}'
                            ]
                        ]
                    )->textarea(['rows' => 6]) ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="widget">
                <header class="widget-header">
                    <h4 class="text-muted m-0">Publish</h4>
                </header><!-- .widget-header -->
                <hr class="widget-separator m-0">
                <div class="widget-body">
                    <?= $form->field($model, 'category_id')->dropdownList($model->getProductCategories(), [
                        //'prompt' => 'Select Category',
                        'data-plugin' => 'select2',
                        'data-options' => "{ placeholder: 'Select Category', allowClear: true }",
                        //'multiple' => true
                    ]); ?>
                    <?= $form->field($model, 'tags')->textInput(['placeholder' => 'add more...', 'data-role' => 'tagsinput', 'data-plugin' => 'tagsinput', 'maxlength' => true]) ?>
                    <?= $form->field($model, 'isActive', [
                        //'checkTemplate' => '<div class="custom-control checkbox checkbox-primary custom-checkbox">{input}{label}{error}{hint}</div>',
                    ])->label('Active')->checkbox([
                        'class' => 'm-r-xs',
                        'data-switchery' => '',
                        'data-color' => '#10c469',
                        'checked' => $model->isActive ? 'checked' : null,
                    ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>
