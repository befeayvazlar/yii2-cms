<?php

/**
 * User: Burak Efe
 * Date: 26.02.2022
 * Time: 10:11
 */

/** @var $model \common\models\Product */

?>

<div class="row">
    <div class="col-md-12">
        <div class="widget">
            <div class="widget-body">
                <form data-method="post" data-url="" action="<?php echo \yii\helpers\Url::to(['/product/image-upload', 'product_id' => $model->product_id]); ?>" id="dropzone" class="dropzone" data-plugin="dropzone" data-options="{ url: '<?php echo \yii\helpers\Url::to(['/product/image-upload', 'product_id' => $model->product_id]); ?>'}">
                    <?=yii\helpers\Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken)?>
                    <div class="dz-message">
                        <h3 class="m-h-lg">Yüklemek istediğiniz resimleri buraya sürükleyiniz</h3>
                        <p class="m-b-lg text-muted">(Yüklemek için dosyalarınızı sürükleyiniz yada buraya tıklayınız)</p>
                    </div>
                </form>
            </div><!-- .widget-body -->
        </div><!-- .widget -->
    </div><!-- END column -->
</div>

<div class="row">
    <div class="col-md-12">
        <h4 class="m-b-lg">
            <b><?php echo $model->title; ?></b> kaydına ait Resimler
        </h4>
    </div><!-- END column -->
    <div class="col-md-12">
        <div class="widget">
            <div class="widget-body image_list_container">



            </div><!-- .widget-body -->
        </div><!-- .widget -->
    </div><!-- END column -->
</div>
