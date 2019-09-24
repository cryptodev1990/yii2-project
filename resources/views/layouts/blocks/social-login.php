<?php

use yii\web\View;

/**
 * @var View $this
 */

?>

<div class="uk-text-center">
    <p class="uk-text-muted">
        <?= t('ui', 'label.social-login') ?>
    </p>

    <nav class="social-login">
        <a href="<?= url(['@social.client', 'authclient' => 'google']) ?>">
            <img src="<?= asset('/assets/static/auth/auth-g.svg') ?>" alt="Login with Google">
        </a>
        <a href="<?= url(['@social.client', 'authclient' => 'facebook']) ?>">
            <img src="<?= asset('/assets/static/auth/auth-fb.svg') ?>" alt="Login with Facebook">
        </a>
        <a href="<?= url(['@social.client', 'authclient' => 'vk']) ?>">
            <img src="<?= asset('/assets/static/auth/auth-vk.svg') ?>" alt="Login with VK">
        </a>
        <a href="<?= url(['@social.client', 'authclient' => 'github']) ?>">
            <img src="<?= asset('/assets/static/auth/auth-git.svg') ?>" alt="Login with Github">
        </a>
    </nav>
</div>