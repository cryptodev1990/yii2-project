<?php

use yii\web\View;

/**
 * @var View $this
 * @var string $icon
 * @var string $title
 * @var string $message
 */

?>

<div class="uk-section-large uk-text-center">
    <div class="uk-h2">
        <i class="material-icons md-64">
            <?= $icon ?>
        </i>
    </div>
    <p class="uk-heading-small">
        <?= $title ?>
    </p>
    <p class="uk-h2">
        <?= $message ?>
    </p>
</div>