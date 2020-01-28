<?php

declare(strict_types=1);

namespace app\core\services;

use app\core\contracts\MailInterface;
use app\core\interfaces\Mailer;
use yii\base\BaseObject;

class MailService extends BaseObject implements Mailer
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
    public function send(MailInterface $mail): bool
    {
        $message = app()->mailer
            ->compose(
                $mail->getView(),
                $mail->getData()
            )
            ->setSubject($mail->getSubject())
            ->setFrom($mail->getFrom())
            ->setTo($mail->getTo());

        return $message->send();
    }
}