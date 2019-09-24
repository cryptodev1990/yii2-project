<?php

use yii\web\View;

/**
 * @var View $this
 */

?>

<?php if (session()->hasFlash('errors')) : ?>
    <div class="uk-alert-danger" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <ul>
            <?php foreach (session()->get('errors') as $item) : ?>
                <li><?= $item ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif ?>

<?php if (session()->hasFlash('messages')) : ?>
    <div class="uk-alert-success" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <ul>
            <?php foreach (session()->get('messages') as $item) : ?>
                <li><?= $item ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif ?>