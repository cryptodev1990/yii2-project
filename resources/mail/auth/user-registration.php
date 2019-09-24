<?php

/**
 * @var string $email
 * @var string $password
 * @var string $link
 * @var bool $isActive
 */

?>

    <h1><?= t('mail', 'auth.registration-complete') ?></h1>

    <p><?= t('mail', 'auth.credentials') ?></p>

    <ul>
        <li><?= t('mail', 'auth.email') ?>: <b><?= $email ?></b></li>
        <li><?= t('mail', 'auth.password') ?>: <b><?= $password ?></b></li>
    </ul>

<?php if (!$isActive) : ?>
    <a href="<?= $link ?>"><?= t('mail', 'auth.complete-registration-button') ?></a>
<?php endif ?>