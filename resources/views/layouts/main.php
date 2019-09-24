<?php

use yii\web\View;

/**
 * @var View $this
 * @var string $content
 */

?>

<?php $this->beginPage() ?>
    <!doctype html>
    <html lang="<?= app()->language ?>">
    <head>
        <meta charset="<?= app()->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $this->title ?></title>
        <?php $this->registerCsrfMetaTags() ?>
        <?php $this->head() ?>
        <link rel="stylesheet" href="<?= asset('/assets/css/app.css') ?>">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>
    <body>
    <?php $this->beginBody() ?>

    <?= $this->render('blocks/navbar') ?>

    <?= $this->render('blocks/notifications') ?>

    <div id="app">
        <?= $content ?>
    </div>

    <script src="<?= asset('/assets/js/app.js') ?>"></script>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>