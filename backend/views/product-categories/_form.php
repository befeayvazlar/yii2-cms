<?php

use yii\helpers\Html;
use \yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ProductCategories */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<?php $action = Yii::$app->controller->action->id;

?>

<div class="product-categories-form">

    <?php ($action === 'index') ? $form = ActiveForm::begin(['action' => '/product-categories/create']) : $form = ActiveForm::begin() ; ?>

    <?php //echo $form->errorSummary($model) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>


    <div class="form-group m-0">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
