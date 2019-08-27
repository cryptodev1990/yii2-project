<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

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
    public function send(Mailable $mail);
}