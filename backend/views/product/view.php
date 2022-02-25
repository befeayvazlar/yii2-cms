<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
                'label' => 'Description',
                'attribute' => 'description',
                'format' => 'html',
                'value' => function ($model) {
                    /** @var \common\models\Product $model */
                    //return Html::tag('span', $model->getStatusLabels()[$model->isActive]);
                    return Html::encode(strip_tags($model->description));
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
