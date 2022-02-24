<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = "Login | ". Yii::$app->name;
?>
<div class="site-login simple-page-wrap">
    <div class="simple-page-logo animated swing">
        <a href="<?= Yii::$app->homeUrl; ?>">
            <span><i class="fa fa-gg"></i></span>
            <span><?= Yii::$app->name ?></span>
        </a>
    </div><!-- logo -->

    <div class="simple-page-form animated flipInY">

        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username',
                [
                    'inputOptions' => [
                            'placeholder' => $model->getAttributeLabel('username')
                    ],
                ]
                )->label(false)->textInput(['autofocus' => true])
            ?>

            <?= $form->field($model, 'password',
                [
                    'inputOptions' => [
                        'placeholder' => $model->getAttributeLabel('password')
                    ],
                ]
                )->label(false)->passwordInput() ?>

            <?= $form->field($model, 'rememberMe',
                [
                    'options' => ['class' => 'form-group m-b-xl'],
                    'checkTemplate' => '<div class="custom-control checkbox checkbox-primary custom-checkbox">{input}{label}{error}{hint}</div>',
                ])->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('GİRİŞ YAP', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>

    <div class="simple-page-footer">
        <p><a href="<?php ?>"><i class="fa fa-lock m-r-5"></i> Şifremi Unuttum?</a></p>
    </div><!-- .simple-page-footer -->

</div>

