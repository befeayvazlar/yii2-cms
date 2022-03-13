<?php

/**
 * User: Burak Efe
 * Date: 26.02.2022
 * Time: 10:11
 */

/** @var $model \common\models\Product */
/** @var $productImageCount integer */

/** @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="row">
    <div class="col-md-12">
        <div class="widget">
            <div class="widget-body">
                <form data-method="post" data-url="<?php echo \yii\helpers\Url::to(['/product/image-reflesh-list', 'product_id' => $model->product_id]); ?>"
                      action="<?php echo \yii\helpers\Url::to(['/product/image-upload', 'product_id' => $model->product_id]); ?>"
                      id="dropzone2" class="dropzone" data-plugin="dropzone"
                      data-options="{ clickable: true, uploadMultiple: true, acceptedFiles: 'image/jpeg,image/png,image/gif,image/webp' }">
                    <?= yii\helpers\Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                    <div class="dz-message">
                        <h3 class="m-h-lg">Drag the images you want to upload here</h3>
                        <p class="m-b-lg text-muted">(Drag your files or click here to upload)</p>
                    </div>
                </form>
            </div><!-- .widget-body -->
        </div><!-- .widget -->
    </div><!-- END column -->
</div>

<div class="row">
    <div class="col-md-12">
        <div>
            <div class="pull-left">
                <?php echo Html::a('<i class="fa fa-chevron-left"></i> Go Back', Yii::$app->request->referrer, [
                    'class' => 'btn btn-sm btn-default'
                ])  ?>
            </div>

            <?php if($productImageCount > 0): ?>
                <div class="pull-right">

                    <?= Html::a('<i class="fa fa-trash"></i> Delete All'.' <strong>('.$productImageCount.')</strong>', ['delete-all-image', 'product_id' => $model->product_id],
                        [
                            'title' => 'Delete All Product Image',
                            'class' => 'btn btn-sm btn-danger',
                            'data-method' => 'post',
                            'data-confirm' => 'Are you sure you want to delete this product all images?',
                        ]
                    ) ?>
                </div>
            <?php endif; ?>
            <h4 class="m-b-lg text-center text-primary center-block">
                Images of <b><?php echo $model->title; ?></b>
            </h4>
        </div>
    </div><!-- END column -->
    <div class="col-md-12">
        <div class="widget">
            <div class="widget-body image_list_container">

                <?php \yii\widgets\Pjax::begin([
                    //'enablePushState'=> false,
                    //'timeout' => 3000
                ]); ?>
                <?= $this->render('_image_list', [
                    'model' => $model,
                    'dataProvider' => $dataProvider
                ]) ?>
                <?php \yii\widgets\Pjax::end(); ?>

            </div><!-- .widget-body -->
        </div><!-- .widget -->
    </div><!-- END column -->
</div>