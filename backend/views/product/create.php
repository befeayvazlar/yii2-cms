<?php

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = 'Create Product';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <h1 class="fz-lg m-b-0"><?= Html::encode($this->title) ?></h1>

    <?php
    echo Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], 'options'=> ['class'=> 'breadcrumb p-v-0', 'style'=> 'background-color:transparent;'],'homeLink' => ['label' => 'Home', 'url' => Yii::$app->homeUrl, 'template' => "<li><i class='fa fa-home m-r-xs text-primary'></i>{link}</li>\n"] , 'activeItemTemplate' => "<li class=\"active\"><strong>{link}</strong></li>\n"]);

    ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
