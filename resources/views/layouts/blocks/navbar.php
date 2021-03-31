<?php

use yii\web\View;

/**
 * @var View $this
 */

?>

<nav class="uk-navbar-container uk-margin" uk-navbar>
    <div class="uk-navbar-left">
        <ul class="uk-navbar-nav">
            <li>
                <a href="<?= url(['/']) ?>"><?= t('ui', 'label.home') ?></a>
            </li>
        </ul>
    </div>

    <div class="uk-navbar-center">
        <a href="<?= url(app()->homeUrl) ?>" class="uk-navbar-item uk-logo">
            <img src="<?= seo()->logo ?>" class="img-brand" alt="<?= seo()->name ?>">
        </a>
    </div>

    <div class="uk-navbar-right">
        <ul class="uk-navbar-nav">
            <?php if (app()->user->isGuest) : ?>
                <li>
                    <a href="<?= url(['@login']) ?>"><?= t('ui', 'label.login') ?></a>
                </li>
                <div class="uk-navbar-item">
                    <a href="<?= url(['@sign-up']) ?>" class="uk-button uk-button-primary"><?= t('ui', 'label.sign-up') ?></a>
                </div>
            <?php else : ?>
                <li>
                    <a href="<?= url(['@me']) ?>"><?= t('ui', 'label.profile') ?></a>
                </li>
                <li>
                    <a href="<?= url(['@logout']) ?>"><?= t('ui', 'label.logout') ?></a>
                </li>
            <?php endif ?>
        </ul>
    </div>
</nav>