<?php

use yii\web\View;

/**
 * @var View $this
 */

?>

<div class="uk-container">
    <div class="uk-align-center uk-width-large uk-section-large">

        <?= $this->render('/layouts/blocks/social-login') ?>

        <div class="uk-divider-icon uk-margin-medium"></div>

        <form action="<?= url(['@login']) ?>" method="post">
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
                <div class="uk-margin-small">
                    <a href="<?= url(['@reset-password']) ?>" class="uk-link-text">
                        <?= t('ui', 'label.reset-password') ?>
                    </a>
                </div>
            </div>

            { reCaptcha(form, 'captcha', 'login') | raw }

            <div class="uk-margin-medium-top uk-text-center">
                <button type="submit" class="uk-button uk-button-primary">
                    <?= t('ui', 'label.login') ?>
                </button>
            </div>

        </form>
    </div>
</div>