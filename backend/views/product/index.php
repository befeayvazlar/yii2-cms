<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

        <?= Html::a('<i class="fa fa-plus p-r-xs"></i>Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'table table-striped bg-white table-bordered',
            //'data-plugin' => 'DataTable',
        ],
        'layout' => '<div class="table-responsive">{items}</div><div class="m-t-md">{summary}</div>{pager}',
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                //'label' => 'Product ID',
                'attribute' => 'product_id',
                'headerOptions' => ['style' => 'width:87px;'],
            ],
            //'product_id',
            'title',
            [
                'label' => 'Status',
                'attribute' => 'isActive',
                'contentOptions' => ['style' => 'width:50px;', 'class' => 'text-center'],
                'content' => function ($model) {
                    /** @var \common\models\Product $model */
                    return Html::tag('span', $model->getStatusLabels()[$model->isActive], [
                        'class' => $model->isActive ? 'badge badge-success' : 'badge badge-danger'
                    ]);
                }
            ],
            [
                'attribute' => 'created_at',
                'format' => ['datetime'],
                //'contentOptions' => ['style'=> 'white-space:nowrap;']
            ],
            'updated_at:datetime',
            //'created_by',
            //'updated_by',
            [
                'class' => ActionColumn::className(),
                'headerOptions' => ['style' => 'width:180px;'],
                'template' => '{view} {update} {delete} {product_images}',
                'buttons' => [
                    'view' => function ($url) {
                        return Html::a('<i class="fa fa-eye"></i>', $url, [
                            'title' => 'View Product', 'class' => 'btn btn-sm btn-success'
                        ]);
                    },
                    'update' => function ($url) {
                        return Html::a('<i class="fa fa-pencil-square-o"></i>', $url, [
                            'title' => 'Update Product', 'class' => 'btn btn-sm btn-info'
                        ]);
                    },
                    'product_images' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-image"></i>', ['image', 'product_id' => $model->product_id],
                            ['title' => 'Product Images', 'class' => 'btn btn-sm btn-dark']
                        );
                    },
                    'delete' => function ($url) {
                        return Html::a('<i class="fa fa-trash"></i>', $url, [
                            'title' => 'Delete Product',
                            'class' => 'btn btn-sm btn-danger',
                            'data-method' => 'post',
                            'data-confirm' => 'Are you sure you want to delete this product?',
                        ]);
                    },
                ],
                'urlCreator' => function ($action, common\models\Product $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'product_id' => $model->product_id]);
                }
            ],
        ],
    ]); ?>


</div>
