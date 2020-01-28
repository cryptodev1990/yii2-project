<?php

declare(strict_types=1);

namespace app\core\contracts;

interface MailInterface
{
    /**
     * @return string|array
     */
    public function getFrom();

    /**
     * @return string
     */
    public function getTo(): string;

    /**
     * @return string
     */
    public function getSubject(): string;

    /**
     * @return string
     */
    public function getView(): string;

    /**
     * @return array
     */
    public function getData(): array;
}