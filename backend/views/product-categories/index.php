<?php

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ProductCategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model \common\models\ProductCategories */

$this->title = 'Product Categories';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss(".product-categories-index .pagination { margin-bottom: 0px; }");

?>
<div class="product-categories-index m-b-md">
    <div class="row">
        <div class="col-md-12">
            <h1 class="fz-lg m-b-0 m-t-0"><?= Html::encode($this->title) ?></h1>

            <?php
            echo Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], 'options' => ['class' => 'breadcrumb p-v-0', 'style' => 'background-color:transparent;'], 'homeLink' => ['label' => 'Home', 'url' => Yii::$app->homeUrl, 'template' => "<li><i class='fa fa-home m-r-xs text-primary'></i>{link}</li>\n"], 'activeItemTemplate' => "<li class=\"active\"><strong>{link}</strong></li>\n"]);

            ?>
        </div>

        <div class="col-md-3">
            <div class="widget">
                <header class="widget-header">
                    <h4 class="text-uppercase m-0">Create Category</h4>
                </header><!-- .widget-header -->
                <hr class="widget-separator m-0">
                <div class="widget-body">
                    <?= $this->render('create', [
                        'model' => $model
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="widget">
                <header class="widget-header">
                    <h4 class="text-uppercase m-0">Category List</h4>
                </header><!-- .widget-header -->
                <hr class="widget-separator m-0">
                <div class="widget-body">
                    <?php Pjax::begin(); ?>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'id' => 'category-reflesh-list',
                        'tableOptions' => [
                            'class' => 'table table-striped bg-white table-bordered content_container',
                            //'data-plugin' => 'DataTable',
                        ],
                        'layout' => '<div class="table-responsive">{items}</div><div class="m-t-md">{summary}</div>{pager}',
                        'columns' => [
                            //['class' => 'yii\grid\SerialColumn'],

                            [
                                'label' => 'ID',
                                'attribute' => 'category_id',
                                'headerOptions' => ['style' => 'width:60px;'],
                            ],
                            'title',
                            [
                                'label' => 'Status',
                                'attribute' => 'isActive',
                                'contentOptions' => ['style' => 'width:126px;', 'class' => 'text-center'],
                                'filter' => Html::activeDropDownList($searchModel, 'isActive', \common\models\ProductCategories::getStatusLabels(), [
                                    'class' => 'form-control',
                                    'prompt' => 'List All',
                                ]),
                                'content' => function ($model) {

                                    /*return Html::tag('span', $model->getStatusLabels()[$model->isActive], [
                                        'class' => $model->isActive ? 'badge badge-success' : 'badge badge-danger'
                                    ]);*/

                                    return Html::input('checkbox', 'isActive', null, [
                                        'class' => 'isActive',
                                        'data-switchery' => '',
                                        'data-color' => '#10c469',
                                        'checked' => $model->isActive ? 'checked' : null,
                                        'data-url' => Url::to(['/product-categories/is-active-setter', 'category_id' => $model->category_id])

                                    ]);

                                }
                                //'format' => ['product']
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
                            //'created_by',
                            //'updated_by',
                            [

                                'class' => ActionColumn::className(),
                                'headerOptions' => ['style' => 'width:94px;'],
                                'template' => '{update} {delete}',
                                'buttons' => [
                                    'update' => function ($url) {
                                        return Html::a('<i class="fa fa-pencil-square-o"></i>', $url, [
                                            //'title' => 'Update Category',
                                            'class' => 'btn btn-sm btn-info update-btn',
                                            'data-pjax' => 0,
                                            'data-toggle' => 'tooltip',
                                            'data-placement' => 'bottom',
                                            'data-original-title' => 'Update Category'
                                        ]);
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
                                            'data-original-title' => 'Delete Category'
                                        ]);
                                    },
                                ],
                                'urlCreator' => function ($action, common\models\ProductCategories $model, $key, $index, $column) {
                                    return Url::toRoute([$action, 'category_id' => $model->category_id, 'page' => Yii::$app->request->getQueryParam('page', null)]);
                                }
                            ]
                        ],
                    ]); ?>

                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>

    </div>
</div>
