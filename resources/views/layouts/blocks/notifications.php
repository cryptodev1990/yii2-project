<?php

use yii\web\View;

/**
 * @var View $this
 */

?>

<?php if (app()->session->hasFlash('errors')) : ?>
    <div class="uk-alert-danger" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <ul>
            <?php foreach (app()->session->get('errors') as $item) : ?>
                <li><?= $item ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif ?>

<?php if (app()->session->hasFlash('messages')) : ?>
    <div class="uk-alert-success" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <ul>
            <?php foreach (app()->session->get('messages') as $item) : ?>
                <li><?= $item ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif ?>