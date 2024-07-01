<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use kartik\icons\Icon;
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
        ['label' => 'Gos2+', 'url' => ['/site/index']],
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
        $menuItems[] = ['label' => 'LIS',
            'items' => [
                ['label' => 'Bridging', 'url' => ['/lis/registration']],
                ['label' => 'Mapping', 'url' => ['/lis/mapping']],
            ]
        ];
        $menuItems[] = ['label' => 'IHS',
            'items' => [
                ['label' => 'Laboratorium Mapping Loinc', 'url' => ['/ihs/mapping-lab']],
            ]
        ];
        $menuItems[] = ['label' => 'Jaspel',
            'items' => [
                ['label' => 'List Tagihan', 'url' => ['/jaspel/tagihan']],
                ['label' => 'Setting Periode', 'url' => ['/jaspel/tagihan/periode']],
                ['label' => 'Klaim Kronis', 'url' => ['/jaspel/kronis/index']],
                ['label' => 'Laporan Rekap Jaspel', 'url' => ['/jaspel/laporan']],
                ['label' => 'Laporan Detail Jaspel', 'url' => ['/jaspel/laporan/detail']],
                ['label' => 'Laporan Jaspel Ambulan', 'url' => ['/jaspel/laporan/ambulan']],
                ['label' => 'Laporan Klaim Jaspel', 'url' => ['/jaspel/laporan/klaim-jaspel']],
            ]
        ];

        $menuItems[] = ['label' => 'Pembayaran',
            'items' => [
                ['label' => 'Jenis Ambulan', 'url' => ['/pembayaran/jenis-ambulan']],
                ['label' => 'Tagihan Ambulan', 'url' => ['/pembayaran/tagihan-ambulan/index']],
                '<div class="dropdown-divider"></div>',
                ['label' => 'Data H2H', 'url' => ['/pembayaran/h2h/index']],
                ['label' => 'Laporan H2H', 'url' => ['/pembayaran/h2h/laporan']],
            ]
        ];
        $menuItems[] = ['label' => 'Terima Berkas','url' => ['/berkas/terima/index']];
        $menuItems[] = ['label' => 'Antrian',
            'items' => [
                ['label' => 'Pengaturan', 'url' => ['/antrian/pengaturan/index']],
                ['label' => 'Jadwal Dokter', 'url' => ['/antrian/jadwal-dokter']],
                ['label' => 'Hari Libur', 'url' => ['/antrian/hari-libur']],
                ['label' => 'Ubah Status Reservasi', 'url' => ['/antrian/reservasi']],
                ['label' => 'Auto Print Label', 'url' => ['/antrian/print-label']],
                ['label' => 'Finger Print', 'url' => ['/antrian/fingerprint']],
            ]
        ];
        $menuItems[] = ['label' => 'Laporan & Rekap',
            'items' => [
                ['label' => 'Detail Pengunjung', 'url' => ['/laporan/laporan/detail-pengunjung']],
                ['label' => 'Rekap Kunjungan', 'url' => ['/laporan/laporan/rekap-kunjungan']],
                ['label' => 'Pasien Ranap', 'url' => ['/laporan/laporan/pasien-ranap']],
                ['label' => 'Pasien Pulang Ranap', 'url' => ['/laporan/laporan/pasien-pulang']],
                ['label' => 'Surat Kontrol', 'url' => ['/laporan/laporan/reservasi-surkon']],
                ['label' => 'Reservasi MJKN', 'url' => ['/laporan/laporan/reservasi-mjkn']],
                ['label' => 'Master Pasien', 'url' => ['/laporan/laporan/pasien']],
            ]
        ];
        $menuItems[] = [
            'label' => 'Logout (' . \Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }

    $menuItems = Mimin::filterMenu($menuItems);
    //$menuItems[] = ['label' => 'APM', 'url' => ['/apm/register']];
    // in other case maybe You want ensure same of route so You can add parameter strict true
    // $menuItems = Mimin::filterMenu($menuItems,true);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
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
<?php Icon::map($this);?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
