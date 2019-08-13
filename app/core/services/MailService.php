<?php

namespace app\core\services;

use app\core\interfaces\Mailer;
use app\extensions\mail\Mailable;
use yii\base\BaseObject;

class MailService extends BaseObject implements Mailer
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
    public function send(Mailable $mail)
    {
        $message = app()->mailer
            ->compose(
                $mail->view(),
                $mail->data()
            )
            ->setSubject($mail->subject())
            ->setFrom($mail->from())
            ->setTo($mail->to());

        return $message->send();
    }
}