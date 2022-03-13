<?php

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var  $pageSize integer */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss(".product-index .pagination { margin-bottom: 0px; }");
?>
<div class="product-index m-b-md">
    <div class="row">

        <div class="col-md-12">
            <h1 class="fz-lg m-b-0 m-t-0"><?= Html::encode($this->title) ?></h1>
            <?php echo Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], 'options' => ['class' => 'breadcrumb p-v-0', 'style' => 'background-color:transparent;'], 'homeLink' => ['label' => 'Home', 'url' => Yii::$app->homeUrl, 'template' => "<li><i class='fa fa-home m-r-xs text-primary'></i>{link}</li>\n"], 'activeItemTemplate' => "<li class=\"active\"><strong>{link}</strong></li>\n"]); ?>
        </div>

        <div class="col-md-12">
            <div>
                <div class="pull-left">
                    <?= Html::a('<i class="fa fa-plus p-r-xs"></i>Create Product', ['create'], ['class' => 'btn btn-success']) ?>
                </div>

                <div class="pull-right m-t-xs">
                    <?php echo $this->render('_search', ['model' => $searchModel, 'pageSize' => $pageSize]); ?>
                </div>
            </div>
        </div>

        <div class="col-md-12">

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => [
                    'class' => 'table table-striped bg-white table-bordered content_container',
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
                    /*[
                        'label' => 'Product Image',
                        'attribute' => 'productImage.img_url',
                    ],*/
                    //'productImage.img_url',
                    [
                        'label' => 'Image',
                        'attribute' => 'img_url',
                        'headerOptions' => ['style' => 'width:50px;'],
                        'content' => function ($model) {
                            /** @var \common\models\Product $model */
                            return Html::img($model->getProductImageLink($model->product_id), [
                                'alt' => $model->title,
                                'data-toggle' => 'tooltip',
                                'data-placement' => 'bottom',
                                'data-original-title' => (!empty($model->productImage->isCover)) ? 'Cover Image' : 'Default Image'
                            ]);
                        }
                    ],
                    'title',
                    [
                        'label' => 'Category',
                        'attribute' => 'category_id',
                        'value' => 'categoryId.title',
                        'headerOptions' => ['style' => 'width:168px;'],
                        'filter' => Html::activeDropDownList($searchModel, 'category_id', \common\models\Product::getProductCategories(), [
                                    'class' => 'form-control',
                                    'prompt' => 'Select Category',
                                ]),
                    ],
                    [
                        'label' => 'Status',
                        'attribute' => 'isActive',
                        'contentOptions' => ['style' => 'width:105px;', 'class' => 'text-center'],
                        'filter' => Html::dropDownList('ProductSearch[isActive]', '', array('' => 'Select') + \common\models\Product::getStatus(), ['prompt' => 'List All', 'class' => 'form-control']),
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
                        'headerOptions' => ['style' => 'width:140px;'],
                        //'contentOptions' => ['style'=> 'white-space:nowrap;']
                    ],
                    [
                        'attribute' => 'updated_at',
                        'format' => ['datetime'],
                        'headerOptions' => ['style' => 'width:140px;'],
                        //'contentOptions' => ['style'=> 'white-space:nowrap;']
                    ],
                    //'updated_at:datetime',
                    //'created_by',
                    //'updated_by',
                    [
                        'class' => ActionColumn::className(),
                        'headerOptions' => ['style' => 'width:180px;'],
                        'template' => '{view} {update} {delete} {product_images}',
                        'buttons' => [
                            'view' => function ($url) {
                                return Html::a('<i class="fa fa-eye"></i>', $url, [
                                    'title' => 'View Product',
                                    'class' => 'btn btn-sm btn-success',
                                    'data-toggle' => 'tooltip',
                                    'data-placement' => 'bottom',
                                    'data-original-title' => 'View Product'
                                ]);
                            },
                            'update' => function ($url) {
                                return Html::a('<i class="fa fa-pencil-square-o"></i>', $url, [
                                    'title' => 'Update Product',
                                    'class' => 'btn btn-sm btn-info',
                                    'data-toggle' => 'tooltip',
                                    'data-placement' => 'bottom',
                                    'data-original-title' => 'Update Product'
                                ]);
                            },
                            'product_images' => function ($url, $model, $key) {
                                return Html::a('<i class="fa fa-image"></i>', ['image', 'product_id' => $model->product_id],
                                    [
                                        'title' => 'Product Images',
                                        'class' => 'btn btn-sm btn-dark',
                                        'data-toggle' => 'tooltip',
                                        'data-placement' => 'bottom',
                                        'data-original-title' => 'Product Images'
                                    ]
                                );
                            },
                            'delete' => function ($url) {
                                return Html::button('<i class="fa fa-trash"></i>', [
                                    //'title' => 'Delete Product',
                                    'class' => 'btn btn-sm btn-danger remove-btn',
                                    'data-url' => $url,
                                    //'data-method' => 'post',
                                    //'data-confirm' => 'Are you sure you want to delete this product?',
                                    'data-toggle' => 'tooltip',
                                    'data-placement' => 'bottom',
                                    'data-original-title' => 'Delete Product'
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

    </div>

</div>
