<?php
/**
 * User: Burak Efe
 * Date: 28.02.2022
 * Time: 11:33
 */

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var $model \common\models\Product */
/** @var $dataProvider yii\data\ActiveDataProvider */

?>

<?=  GridView::widget([
    'id' => 'image-reflesh-list',
    'dataProvider' => $dataProvider,
    'tableOptions' => [
        'class' => 'table table-striped bg-white table-bordered',
        //'data-plugin' => 'DataTable',
    ],
    'emptyText' => 'Product images not found. Please upload an image.',
    'layout' => '<div class="table-responsive">{items}</div><div class="m-t-md">{summary}</div>{pager}',
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'],
        [
            //'label' => 'Product ID',
            'attribute' => 'id',
            'headerOptions' => ['style' => 'width:20px;'],
        ],
        //'product.product_id',
        [
            'label' => 'Image',
            'attribute' => 'img_url',
            'headerOptions' => ['style' => 'width:50px;'],
            'content' => function ($model) {
                /** @var \common\models\ProductImage $model */
                return
                    Html::a(Html::img($model->getThumbnailLink(), [
                        /*'srcset' => [
                            '1x' => $model->getThumbnailLink(),
                            '2x' => $model->getImageLink('1080x426', $model->img_url),
                        ],*/
                        'style' => 'width: 50px',
                        'alt' => $model->product->title,
                    ]), $model->getImageLink('1080x426', $model->img_url), [
                        //'class' => 'btn btn-xs btn-success',
                        'data-lightbox' => $model->product->title,
                        'data-title' => $model->product->title,
                    ]);
            }
        ],
        'img_url',
        'created_at:datetime',
        'updated_at:datetime',
        [
            'label' => 'Status',
            'attribute' => 'isActive',
            'contentOptions' => ['style' => 'width:50px;', 'class' => 'text-center'],
            'content' => function ($model) {
                /** @var \common\models\ProductImage $model */
                /*return Html::tag('span', $model->isActive ? 'Published' : 'Draft', [
                    'class' => $model->isActive ? 'badge badge-success' : 'badge badge-danger'
                ]);*/
                return Html::input('checkbox', 'isActive', null, [
                    'class' => 'isActive',
                    'data-switchery' => '',
                    'data-color' => '#10c469',
                    'checked' => $model->isActive ? 'checked' : null,
                    'data-url' => Url::to(['/product/is-active-setter', 'id' => $model->id])

                ]);
            }
        ],
        [
            'label' => 'Cover',
            'attribute' => 'isCover',
            'contentOptions' => ['style' => 'width:50px;', 'class' => 'text-center'],
            'content' => function ($model) {
                /** @var \common\models\ProductImage $model */
                /*return Html::tag('span', $model->isActive ? 'Published' : 'Draft', [
                    'class' => $model->isActive ? 'badge badge-success' : 'badge badge-danger'
                ]);*/
                return Html::input('checkbox', 'isCover', null, [
                    'class' => 'isCover',
                    'data-switchery' => '',
                    'data-color' => '#ff5b5b',
                    'checked' => $model->isCover ? 'checked' : null,
                    'data-url' => Url::to(['/product/is-cover-setter', 'id' => $model->id, 'product_id'=> $model->product_id])

                ]);
            }
        ],
        //'updated_at',
        //'created_by',
        //'updated_by',
        [
            'class' => ActionColumn::className(),
            'headerOptions' => ['style' => 'width:40px;'],
            'template' => '{image-delete}',
            'buttons' => [
                'image-delete' => function ($url, $model, $key) {
                    return Html::button('<i class="fa fa-trash"></i>',
                        [
                            'title' => 'Delete Product',
                            'class' => 'btn btn-sm btn-danger remove-btn',
                            'data-url' => Url::to(['/product/image-delete', 'id' => $model->id]),
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'bottom',
                            'data-original-title' => 'Delete Product'
                            //'data-method' => 'post',
                            //'data-confirm' => 'Are you sure you want to delete this product image?',
                        ]
                    );
                },
            ],
            'urlCreator' => function ($action, common\models\ProductImage $model, $key, $index, $column) {
                return Url::toRoute([$action, 'product_id' => $model->product_id]);
            }
        ],
    ],
]); ?>
