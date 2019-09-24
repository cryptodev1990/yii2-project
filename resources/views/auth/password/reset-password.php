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

        <form action="{{ path(['@reset-password']) }}" method="post">
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

            <div class="uk-margin uk-text-center">
                <button type="submit" class="uk-button uk-button-primary uk-margin-top">
                    <?= t('ui', 'label.continue') ?>
                </button>
            </div>
        </form>
    </div>
</div>