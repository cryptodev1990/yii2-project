<?php

use app\forms\auth\LoginForm;
use manchenkov\yii\recaptcha\ReCaptchaWidget;
use yii\web\View;

/**
 * @var View $this
 * @var LoginForm $form
 */

?>

<div class="uk-container">
    <div class="uk-align-center uk-width-large uk-section-large">

        <?= $this->render('/layouts/blocks/social-login') ?>

        <div class="uk-divider-icon uk-margin-medium"></div>

        <form action="<?= url(['@login']) ?>" method="post">
            <?= csrf() ?>

            <div class="uk-margin">
                <div class="uk-inline uk-display-block">
                    <span class="uk-form-icon material-icons">alternate_email</span>
                    <input type="text"
                           class="uk-input <?= $form->hasErrors('email') ? 'uk-form-danger' : ''  ?>"
                           placeholder="<?= $form->getAttributeLabel('email') ?>"
                           id="input-login"
                           name="<?= $form->formName() ?>[email]"
                           value="<?= $form->email ?>"
                           autocomplete="off">
                </div>
            </div>

            <div class="uk-margin">
                <div class="uk-inline uk-display-block">
                    <span class="uk-form-icon material-icons">lock</span>
                    <input type="password"
                           class="uk-input <?= $form->hasErrors('password') ? 'uk-form-danger' : ''  ?>"
                           placeholder="<?= $form->getAttributeLabel('password') ?>"
                           id="input-password"
                           name="<?= $form->formName() ?>[password]"
                           value="<?= $form->password ?>"
                           autocomplete="off">
                </div>
                <div class="uk-margin-small">
                    <a href="<?= url(['@reset-password']) ?>" class="uk-link-text">
                        <?= t('ui', 'label.reset-password') ?>
                    </a>
                </div>
            </div>

            <?= ReCaptchaWidget::widget([
                'model' => $form,
                'action' => 'captcha',
                'attribute' => 'email',
            ]) ?>

            <div class="uk-margin-medium-top uk-text-center">
                <button type="submit" class="uk-button uk-button-primary">
                    <?= t('ui', 'label.login') ?>
                </button>
            </div>

        </form>
    </div>
</div>