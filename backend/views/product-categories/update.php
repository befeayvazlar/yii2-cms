<?php

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProductCategories */

$this->title = 'Update Category: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Product Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['update', 'category_id' => $model->category_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-categories-update">
    <div class="row">
        <div class="col-md-12">
            <h1 class="fz-lg m-b-0"><?= Html::encode($this->title) ?></h1>

            <?php
            echo Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], 'options' => ['class' => 'breadcrumb p-v-0', 'style' => 'background-color:transparent;'], 'homeLink' => ['label' => 'Home', 'url' => Yii::$app->homeUrl, 'template' => "<li><i class='fa fa-home m-r-xs text-primary'></i>{link}</li>\n"], 'activeItemTemplate' => "<li class=\"active\"><strong>{link}</strong></li>\n"]);
            ?>
        </div>
        <div class="col-md-3">
            <div class="widget">
                <header class="widget-header">
                    <h4 class="text-uppercase m-0">Update Category</h4>
                </header><!-- .widget-header -->
                <hr class="widget-separator m-0">
                <div class="widget-body">
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>



        </div>
    </div>

</div>
