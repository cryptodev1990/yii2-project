<?php

use app\forms\auth\SetPasswordForm;
use yii\web\View;

/**
 * @var View $this
 * @var SetPasswordForm $form
 * @var string $token
 */

?>

<div class="uk-container">
    <div class="uk-align-center uk-width-xlarge uk-section-large">
        <h1 class="uk-text-center uk-margin-medium-bottom">
            <?= t('ui', 'label.reset-password') ?>
        </h1>

        <form action="<?= url(['@set-password', 'token' => $token]) ?>" method="post">
            <?= csrf() ?>

            <div class="uk-margin">
                <div class="uk-inline uk-display-block">
                    <span class="uk-form-icon material-icons">lock</span>
                    <input type="password"
                           class="uk-input <?= $form->hasErrors('password') ? 'uk-form-danger' : '' ?>"
                           placeholder="<?= $form->getAttributeLabel('password') ?>"
                           id="input-password"
                           name="<?= $form->formName() ?>[password]"
                           value="<?= $form->password ?>"
                           autocomplete="off">
                </div>
                <?php if ($form->hasErrors('password')) : ?>
                    <div class="uk-text-danger">
                        <?= $form->getFirstError('password') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="uk-margin uk-text-center">
                <button type="submit" class="uk-button uk-button-primary uk-margin-top">
                    <?= t('ui', 'label.continue') ?>
                </button>
            </div>
        </form>
    </div>
</div>¬