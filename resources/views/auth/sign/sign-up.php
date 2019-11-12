<?php

use app\forms\auth\SignUpForm;
use yii\web\View;

/**
 * @var View $this
 * @var SignUpForm $form
 */

?>

<div class="uk-container">
    <div class="uk-align-center uk-width-large uk-section-large">
        <h1 class="uk-text-center uk-margin-medium-bottom">
            <?= t('ui', 'label.sign-up') ?>
        </h1>

        <form action="<?= url(['@sign-up']) ?>" method="post">
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
                <?php if ($form->hasErrors('email')) : ?>
                    <div class="uk-text-danger">
                        <?= $form->getFirstError('email') ?>
                    </div>
                <?php endif; ?>
            </div>

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

            <div class="uk-margin">
                <div class="uk-inline uk-display-block">
                    <span class="uk-form-icon material-icons">person</span>
                    <input type="text"
                           class="uk-input <?= $form->hasErrors('firstName') ? 'uk-form-danger' : '' ?>"
                           placeholder="<?= $form->getAttributeLabel('firstName') ?>"
                           id="input-firstname"
                           name="<?= $form->formName() ?>[firstName]"
                           value="<?= $form->firstName ?>"
                           autocomplete="off">
                </div>
                <?php if ($form->hasErrors('firstName')) : ?>
                    <div class="uk-text-danger">
                        <?= $form->getFirstError('firstName') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="uk-margin">
                <div class="uk-inline uk-display-block">
                    <span class="uk-form-icon material-icons">person</span>
                    <input type="text"
                           class="uk-input <?= $form->hasErrors('lastName') ? 'uk-form-danger' : '' ?>"
                           placeholder="<?= $form->getAttributeLabel('lastName') ?>"
                           id="input-lastname"
                           name="<?= $form->formName() ?>[lastName]"
                           value="<?= $form->lastName ?>"
                           autocomplete="off">
                </div>
                <?php if ($form->hasErrors('lastName')) : ?>
                    <div class="uk-text-danger">
                        <?= $form->getFirstError('lastName') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="uk-margin uk-text-center">
                <button type="submit" class="uk-button uk-button-primary uk-margin-top">
                    <?= t('ui', 'label.continue') ?>
                </button>
            </div>
        </form>

        <div class="uk-divider-icon uk-text-center uk-margin-medium"></div>

        <?= $this->render('/layouts/blocks/social-login') ?>

    </div>
</div>