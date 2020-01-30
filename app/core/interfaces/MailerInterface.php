<?php

declare(strict_types=1);

namespace app\core\interfaces;

interface MailerInterface
{
    /**
     * Method for build and send composed mail object
     *
     * Set mailer properties: `from`, `to`, `subject`, `view`, `data`
     * Use to send: `send()`
     *
     * @param MailInterface $mail
     *
     * @return bool
     */
    public function send(MailInterface $mail): bool;
}