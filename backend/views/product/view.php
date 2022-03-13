<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

    <h1 class="fz-lg m-b-0"><?= Html::encode($this->title) ?></h1>

    <?php
    echo Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], 'options'=> ['class'=> 'breadcrumb p-v-0', 'style'=> 'background-color:transparent;'],'homeLink' => ['label' => 'Home', 'url' => Yii::$app->homeUrl, 'template' => "<li><i class='fa fa-home m-r-xs text-primary'></i>{link}</li>\n"] , 'activeItemTemplate' => "<li class=\"active\"><strong>{link}</strong></li>\n"]);

    ?>

    <p>
        <?= Html::a('<i class="fa fa-pencil-square-o p-r-xs"></i>Update', ['update', 'product_id' => $model->product_id], ['class' => 'btn btn-info']) ?>
        <?= Html::a('<i class="fa fa-trash p-r-xs"></i>Delete', ['delete', 'product_id' => $model->product_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'options' => [
            'class' => 'table table-striped bg-white table-bordered',
            //'data-plugin' => 'DataTable',
        ],
        'attributes' => [
            'product_id',
            'title',
            [
                'label' => 'Image',
                'attribute' => 'img_url',
                'format' => 'raw',
                'value' => function ($model) {
                    /** @var \common\models\Product $model */
                    return Html::img($model->getProductImageLink($model->product_id), [
                        'alt' => $model->title,
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'bottom',
                        'data-original-title' => (!empty($model->productImage->isCover)) ? 'Cover Image' : 'Default Image'
                    ]);
                }
            ],
            [
                'label' => 'Description',
                'attribute' => 'description',
                'format' => 'html',
                'value' => function ($model) {
                    /** @var \common\models\Product $model */
                    //return Html::tag('span', $model->getStatusLabels()[$model->isActive]);
                    return Html::encode(\yii\helpers\StringHelper::truncateWords(strip_tags($model->description),20) );
                }
            ],
            [
                'label' => 'Category',
                'attribute' => 'categoryId.title',
                //'value' => 'categoryId.title',
            ],
            [
                'label' => 'Tags',
                'attribute' => 'tags',
                'format' => 'raw',
                'value' => function ($model) {
                    $tag = '';
                    $tags = explode(',', $model->tags);
                        for ($i = 0; $i < count($tags); $i++){
                            //var_dump($tag);
                           $tag .= Html::tag('span', $tags[$i], [
                                   'class' => 'label label-info m-r-xs'
                           ]);

                        }
                    return $tag;
                }
            ],
            //'rank',
            [
                'label' => 'Status',
                'attribute' => 'isActive',
                'format' => 'html',
                'value' => function ($model) {
                    /** @var \common\models\Product $model */
                    return Html::tag('span', $model->getStatusLabels()[$model->isActive], [
                        'class' => $model->isActive ? 'badge badge-success' : 'badge badge-danger'
                    ]);
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',
            'createdBy.username',
            'updatedBy.username',
        ],
    ]) ?>

</div>
