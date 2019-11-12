<?php

use app\forms\auth\ResetPasswordForm;
use yii\web\View;

/**
 * @var View $this
 * @var ResetPasswordForm $form
 */

?>

<div class="uk-container">
    <div class="uk-align-center uk-width-xlarge uk-section-large">
        <h1 class="uk-text-center uk-margin-medium-bottom">
            <?= t('ui', 'label.reset-password') ?>
        </h1>

        <form action="<?= url(['@reset-password']) ?>" method="post">
            <?= csrf() ?>

            <div class="uk-margin">
                <div class="uk-inline uk-display-block">
                    <span class="uk-form-icon material-icons">alternate_email</span>
                    <input type="text"
                           class="uk-input <?= $form->hasErrors('email') ? 'uk-form-danger' : '' ?>"
                           placeholder="<?= $form->getAttributeLabel('email') ?>"
                           id="input-login"
                           name="<?= $form->formName() ?>[email]"
                           value="<?= $form->email ?>"
                           autocomplete="off">
                </div>
            </div>

            <div class="uk-margin uk-text-center">
                <button type="submit" class="uk-button uk-button-primary uk-margin-top">
                    <?= t('ui', 'label.continue') ?>
                </button>
            </div>
        </form>
    </div>
</div>