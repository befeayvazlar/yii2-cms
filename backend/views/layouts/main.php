<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use common\widgets\Alert;
Use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script src="/libs/bower/breakpoints.js/dist/breakpoints.min.js"></script>
    <script>
        Breakpoints();
    </script>
</head>
<body class="menubar-left menubar-unfold menubar-light theme-primary">
<?php $this->beginBody() ?>

<!--============= start main area -->

<!-- APP NAVBAR ==========-->
<?= $this->render('_navbar'); ?>
<!--========== END app navbar -->

<!-- APP ASIDE ==========-->
<?= $this->render('_sidebar'); ?>
<!--========== END app aside -->

<!-- navbar search -->
<?= $this->render('_navbar-search'); ?>
<!-- .navbar-search -->

<!-- APP MAIN ==========-->
<main id="app-main" class="app-main">

    <div class="wrap">

        <?= $content ?>

    </div><!-- .wrap -->

    <!-- APP FOOTER -->
    <?= $this->render('_footer'); ?>
    <!-- /#app-footer -->

</main>

<?php $this->endBody() ?>

    <?= $this->render('_alert'); ?>
</body>
</html>
<?php $this->endPage();


