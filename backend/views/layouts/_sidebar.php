<?php
/**
 * User: Burak Efe
 * Date: 24.02.2022
 * Time: 14:57
 */
?>

<aside id="menubar" class="menubar light">
    <div class="app-user">
        <div class="media">
            <div class="media-left">
                <div class="avatar avatar-md avatar-circle">
                    <a href="javascript:void(0)"><img class="img-responsive" src="/images/221.jpg" alt="avatar"/></a>
                </div><!-- .avatar -->
            </div>
            <div class="media-body">
                <div class="foldable">
                    <h5><a href="javascript:void(0)" class="username"><?= Yii::$app->user->identity->getDisplayName() ?></a></h5>
                    <ul>
                        <li class="dropdown">
                            <a href="javascript:void(0)" class="dropdown-toggle usertitle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <small>İşlemler</small>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu animated flipInY">
                                <li>
                                    <a class="text-color" href="<?= Yii::$app->homeUrl ?>">
                                        <span class="m-r-xs"><i class="fa fa-home"></i></span>
                                        <span>Anasayfa</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="text-color" href="<?= \yii\helpers\Url::to(['profile/index']) ?>">
                                        <span class="m-r-xs"><i class="fa fa-user"></i></span>
                                        <span>Profilim</span>
                                    </a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a class="text-color" href="<?= \yii\helpers\Url::to(['site/logout']) ?>" data-method="post">
                                        <span class="m-r-xs"><i class="fa fa-power-off"></i></span>
                                        <span>Çıkış</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div><!-- .media-body -->
        </div><!-- .media -->
    </div><!-- .app-user -->

    <div class="menubar-scroll">
        <div class="menubar-scroll-inner">
            <ul class="app-menu">
                <li <?= (Yii::$app->controller->id === 'site') ? 'class="active"' : '' ?>>
                    <a href="<?= Yii::$app->homeUrl ?>">
                        <i class="menu-icon zmdi zmdi-view-dashboard zmdi-hc-lg"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>

                <li <?= (Yii::$app->controller->id === 'settings') ? 'class="active"' : '' ?>>
                    <a href="<?= \yii\helpers\Url::to(['settings/index']) ?>">
                        <i class="menu-icon zmdi zmdi-settings zmdi-hc-lg"></i>
                        <span class="menu-text">Ayarlar</span>
                    </a>
                </li>

                <li <?= (Yii::$app->controller->id === 'menu') ? 'class="active"' : '' ?>>
                    <a href="<?= \yii\helpers\Url::to(['menu/index']) ?>">
                        <i class="menu-icon zmdi zmdi-menu zmdi-hc-lg"></i>
                        <span class="menu-text">Menü</span>
                    </a>
                </li>

                <li <?= (Yii::$app->controller->id === 'emailsettings') ? 'class="active"' : '' ?>>
                    <a href="<?= \yii\helpers\Url::to(['emailsettings/index']) ?>">
                        <i class="menu-icon zmdi zmdi-email zmdi-hc-lg"></i>
                        <span class="menu-text">E-posta Ayarları</span>
                    </a>
                </li>

                <li <?= (Yii::$app->controller->id === 'galleries') ? 'class="active"' : '' ?>>
                    <a href="<?= \yii\helpers\Url::to(['galleries/index']) ?>">
                        <i class="menu-icon zmdi zmdi-apps zmdi-hc-lg"></i>
                        <span class="menu-text">Galeriler</span>
                    </a>
                </li>

                <li  <?= (Yii::$app->controller->id === 'slides') ? 'class="active"' : '' ?>>
                    <a href="<?= \yii\helpers\Url::to(['slides/index']) ?>">
                        <i class="menu-icon zmdi zmdi-layers zmdi-hc-lg"></i>
                        <span class="menu-text">Slider</span>
                    </a>
                </li>

                <li <?= (Yii::$app->controller->id === 'product') ? 'class="active"' : '' ?>>
                    <a href="<?= \yii\helpers\Url::to(['product/index']) ?>">
                        <i class="menu-icon fa fa-cubes"></i>
                        <span class="menu-text">Ürünler</span>
                       <!-- <?php /*if((getCountTable("products")) > 0) { */?>
                            <span class="label label-warning menu-label"><?php /*echo getCountTable("products"); */?></span>
                        --><?php /*} */?>
                    </a>
                </li>

                <li <?= (Yii::$app->controller->id === 'services') ? 'class="active"' : '' ?>>
                    <a href="<?= \yii\helpers\Url::to(['services/index']) ?>">
                        <i class="menu-icon zmdi zmdi-assignment-check zmdi-hc-lg"></i>
                        <span class="menu-text">Hizmetler</span>
                    </a>
                </li>

                <li class="has-submenu <?= (Yii::$app->controller->id === 'portfolio_categories' ? 'active' : '' || Yii::$app->controller->id ==='portfolio') ? 'open' : '' ?>">
                    <a href="javascript:void(0)" class="submenu-toggle">
                        <i class="menu-icon zmdi zmdi-collection-image zmdi-hc-lg"></i>
                        <span class="menu-text">Portfolyo İşlemleri</span>
                        <i class="menu-caret zmdi zmdi-hc-sm zmdi-chevron-right"></i>
                    </a>
                    <ul class="submenu" style="<?= (Yii::$app->controller->id === 'portfolio_categories' || Yii::$app->controller->id ==='portfolio') ? 'display:block;' : '' ?>">
                        <li class="<?=(Yii::$app->controller->id ==='portfolio_categories')?'active':''?>"><a href="<?= \yii\helpers\Url::to(['portfolio_categories/index']) ?>"><span class="menu-text">Portfolyo Kategorileri</span></a></li>
                        <li class="<?=(Yii::$app->controller->id ==='portfolio')?'active':''?>"><a href="<?= \yii\helpers\Url::to(['portfolio/index']) ?>"><span class="menu-text">Portfolyo</span></a></li>
                    </ul>
                </li>

                <li class="<?=(Yii::$app->controller->id==='news')?'active':''?>">
                    <a href="<?= \yii\helpers\Url::to(['news/index']) ?>">
                        <i class="menu-icon fa fa-newspaper-o"></i>
                        <span class="menu-text">Haberler</span>
                        <?php /*if((getCountTable("news")) > 0) { */?><!--
                            <span class="label label-warning menu-label"><?php /*echo getCountTable("news"); */?></span>
                        --><?php /*} */?>
                    </a>
                </li>
                <li class="<?=(Yii::$app->controller->id==='courses')?'active':''?>">
                    <a href="<?= \yii\helpers\Url::to(['courses/index']) ?>">
                        <i class="menu-icon fa fa-calendar"></i>
                        <span class="menu-text">Eğitimler</span>
                    </a>
                </li>
                <li class="<?=(Yii::$app->controller->id==='references')?'active':''?>">
                    <a href="<?= \yii\helpers\Url::to(['references/index']) ?>">
                        <i class="menu-icon zmdi zmdi-check zmdi-hc-lg"></i>
                        <span class="menu-text">Referanslar</span>
                    </a>
                </li>
                <li class="<?=(Yii::$app->controller->id==='brands')?'active':''?>">
                    <a href="<?= \yii\helpers\Url::to(['brands/index']) ?>">
                        <i class="menu-icon zmdi zmdi-puzzle-piece zmdi-hc-lg"></i>
                        <span class="menu-text">Markalar</span>
                    </a>
                </li>
                <li class="<?=(Yii::$app->controller->id==='user_roles')?'active':''?>">
                    <a href="<?= \yii\helpers\Url::to(['user_roles/index']) ?>">
                        <i class="menu-icon fa fa-user-times"></i>
                        <span class="menu-text">Kullanıcı Rolleri</span>
                    </a>
                </li>
                <li class="<?=(Yii::$app->controller->id==='users')?'active':''?>">
                    <a href="<?= \yii\helpers\Url::to(['users/index']) ?>">
                        <i class="menu-icon fa fa-user-secret"></i>
                        <span class="menu-text">Kullanıcılar</span>
                    </a>
                </li>
                <li class="<?=(Yii::$app->controller->id==='members')?'active':''?>">
                    <a href="<?= \yii\helpers\Url::to(['members/index']) ?>">
                        <i class="menu-icon fa fa-users"></i>
                        <span class="menu-text">Aboneler</span>
                        <?php /*if((getCountTable("members")) > 0) { */?><!--
                            <span class="label label-warning menu-label"><?php /*echo getCountTable("members"); */?></span>
                        --><?php /*} */?>
                    </a>
                </li>
                <li class="<?=(Yii::$app->controller->id==='testimonials')?'active':''?>">
                    <a href="<?= \yii\helpers\Url::to(['testimonials/index']) ?>">
                        <i class="menu-icon fa fa-commenting"></i>
                        <span class="menu-text">Ziyaretçi Notları</span>
                    </a>
                </li>
                <li class="<?=(Yii::$app->controller->id==='popups')?'active':''?>">
                    <a href="<?= \yii\helpers\Url::to(['popups/index']) ?>">
                        <i class="menu-icon zmdi zmdi-lamp zmdi-hc-lg"></i>
                        <span class="menu-text">Popup Hizmeti</span>
                    </a>
                </li>
                <li class="<?=(Yii::$app->controller->id==='reports')?'active':''?>">
                    <a href="<?= \yii\helpers\Url::to(['reports/index']) ?>">
                        <i class="menu-icon zmdi zmdi-chart zmdi-hc-lg"></i>
                        <span class="menu-text">Raporlar</span>
                        <?php /*if((getCountTable("logs")) > 0) { */?><!--
                            <span class="label label-info menu-label"><?php /*echo getCountTable("logs"); */?></span>
                        --><?php /*} */?>
                    </a>
                </li>

                <li class="menu-separator"><hr></li>

                <li>
                    <a href="documentation.html">
                        <i class="menu-icon zmdi zmdi-file-text zmdi-hc-lg"></i>
                        <span class="menu-text">Siteye Git</span>
                    </a>
                </li>

            </ul><!-- .app-menu -->
        </div><!-- .menubar-scroll-inner -->
    </div><!-- .menubar-scroll -->
</aside>
