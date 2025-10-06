<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

$current_user = Yii::$app->user;
AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>
<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => '<i class="fa fa-road"></i> '.Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'encodeLabels' => false,
        'items' => [
            // ['label' => 'Acasa', 'url' => ['/site/index']],  
            // !Yii::$app->user->isGuest ?['label' => 'Conducatori auto', 'url' => ['/driver']]:'', 
            !$current_user->isGuest ?['label' => '<i class="fa fa-truck"></i> Camioane', 'url' => ['/vehicle']]:'', 
            !$current_user->isGuest ?['label' => '<i class="fa fa-building"></i> Clienti', 'url' => ['/partner']]:'', 
            !$current_user->isGuest ?['label' => '<i class="fa fa-file-invoice"></i> Comenzi', 'url' => ['/transport-order']]:'',
            !$current_user->isGuest && ($current_user->identity->isAdmin() || $current_user->identity->isContabil()) ? ['label' => '<i class="fa fa-money-bill"></i> Contabilitate',
                'items' => [                
                ['label' => '<i class="fa fa-credit-card"></i> Plati Parteneri', 'url' => ['/payment']],
               /*  '<hr class="dropdown-divider">',
                ['label' => 'Consulting', 'url' => ['/services/consulting']],*/
            ],]:'',            
            ( !$current_user->isGuest && $current_user->identity->isAdmin())?  ['label' => 'Utilizatori', 'url' => ['/user']]:'',                        
            $current_user->isGuest
                ? ['label' => '<i class="fa fa-sign-in"></i> Intră în cont', 'url' => ['/site/login']]
                : '<li class="nav-item">'
                    . Html::beginForm(['/site/logout'])
                    . Html::submitButton(
                        '<i class="fa fa-sign-out"></i> Deconectare [ ' . $current_user->identity->username.' ]',
                        ['class' => 'nav-link btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
        ]
    ]);
    NavBar::end();
    ?>
</header>
    <div class="container-fluid mt-5 pt-2">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; <?= Yii::$app->name.' '. date('Y') ?></div>           
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
