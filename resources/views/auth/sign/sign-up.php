<?php

use yii\web\View;

/**
 * @var View $this
 */

?>

<div class="uk-container">
    <div class="uk-align-center uk-width-large uk-section-large">
        <h1 class="uk-text-center uk-margin-medium-bottom">
            <?= t('ui', 'label.sign-up') ?>
        </h1>

        <form action="<?= url(['@sign-up']) ?>" method="post">
            { csrf() | raw }

            <div class="uk-margin">
                <div class="uk-inline uk-display-block">
                    <span class="uk-form-icon material-icons">alternate_email</span>
                    <input type="text"
                           class="uk-input {{ form.errors.email ? 'uk-form-danger' : '' }}"
                           placeholder="{{ form_label(form, 'email') }}"
                           id="input-login"
                           name="{{ form_field(form, 'email') }}"
                           value="{{ form.email }}"
                           autocomplete="off">
                </div>
            </div>

            <div class="uk-margin">
                <div class="uk-inline uk-display-block">
                    <span class="uk-form-icon material-icons">lock</span>
                    <input type="password"
                           class="uk-input {{ form.errors.password ? 'uk-form-danger' : '' }}"
                           placeholder="{{ form_label(form, 'password') }}"
                           id="input-password"
                           name="{{ form_field(form, 'password') }}"
                           value="{{ form.password }}"
                           autocomplete="off">
                </div>
            </div>

            <div class="uk-margin">
                <div class="uk-inline uk-display-block">
                    <span class="uk-form-icon material-icons">person</span>
                    <input type="text"
                           class="uk-input {{ form.errors.firstName ? 'uk-form-danger' : '' }}"
                           placeholder="{{ form_label(form, 'firstName') }}"
                           id="input-firstname"
                           name="{{ form_field(form, 'firstName') }}"
                           value="{{ form.firstName }}"
                           autocomplete="off">
                </div>
            </div>

            <div class="uk-margin">
                <div class="uk-inline uk-display-block">
                    <span class="uk-form-icon material-icons">person</span>
                    <input type="text"
                           class="uk-input {{ form.errors.lastName ? 'uk-form-danger' : '' }}"
                           placeholder="{{ form_label(form, 'lastName') }}"
                           id="input-lastname"
                           name="{{ form_field(form, 'lastName') }}"
                           value="{{ form.lastName }}"
                           autocomplete="off">
                </div>
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