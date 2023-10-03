<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use hscstudio\mimin\components\Mimin;

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
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        //'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);

    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
    ];

    if (\Yii::$app->user->isGuest){
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
    }
    else{
        $menuItems[] = ['label' => 'Manage User',
            'items' => [
                ['label' => 'Route', 'url' => ['/mimin/route']],
                ['label' => 'Role', 'url' => ['/mimin/role']],
                ['label' => 'User', 'url' => ['/mimin/user']],
            ]
        ];
        $menuItems[] = ['label' => 'Test', 'url' => ['/site/testdb2']];
        $menuItems[] = [
            'label' => 'Logout (' . \Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }

    $menuItems = Mimin::filterMenu($menuItems);
    $menuItems[] = ['label' => 'APM', 'url' => ['/apm/register']];
    // in other case maybe You want ensure same of route so You can add parameter strict true
    // $menuItems = Mimin::filterMenu($menuItems,true);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    /*echo "<pre>";
    print_r($menuItems);
    echo "</pre>";*/
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-left">&copy; RSTN <?= date('Y') ?></p>
        <p class="float-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
