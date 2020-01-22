<?php

declare(strict_types=1);

namespace app\core\interfaces;

use manchenkov\yii\mail\Mailable;

interface Mailer
{
    /**
     * Method for build and send composed mail object
     *
     * Set mailer properties: `from`, `to`, `subject`, `view`, `data`
     * Use to send: `send()`
     *
     * @param Mailable $mail
     *
     * @return bool
     */
    public function send(Mailable $mail): bool;
}