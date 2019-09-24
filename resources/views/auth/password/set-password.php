<?php

use yii\web\View;

/**
 * @var View $this
 */

?>

    <div class="uk-container">
        <div class="uk-align-center uk-width-xlarge uk-section-large">
            <h1 class="uk-text-center uk-margin-medium-bottom">
                <?= t('ui', 'label.reset-password') ?>
            </h1>

            <form action="<?= url(['@set-password', 'token' => $token])?>" method="post">
                { csrf() | raw }

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

                <div class="uk-margin uk-text-center">
                    <button type="submit" class="uk-button uk-button-primary uk-margin-top">
                        <?= t('ui', 'label.continue') ?>
                    </button>
                </div>
            </form>
        </div>
    </div>¬