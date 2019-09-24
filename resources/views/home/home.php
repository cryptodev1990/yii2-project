<?php

use yii\web\View;

/**
 * @var View $this
 */

?>

<h1>Home</h1>

<ul>
    <?php if (user()->can('admin')) : ?>
        <li>Role: admin</li>
    <?php else : ?>
        <li>Role: user</li>
    <?php endif ?>

    <?php if (user()->can('confirmed')) : ?>
        <li>Status: active</li>
    <?php else : ?>
        <li>Status: inactive</li>
    <?php endif ?>
</ul>