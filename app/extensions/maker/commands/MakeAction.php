<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\extensions\maker\commands;

use Exception;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\console\ExitCode;

/**
 * Class MakeAction
 * @package app\extensions\maker\actions
 */
abstract class MakeAction extends Action
{
    /**
     * Parent controller
     * @var MakeController
     */
    public $controller;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (!$this->controller instanceof MakeController) {
            throw new InvalidConfigException('This action must be in a MakeController only!');
        }

        parent::init();
    }

    /**
     * Shows error message
     *
     * @param string $message
     */
    public function error(string $message)
    {
        $this->controller->error($message);

        return;
    }

    /**
     * Shows info message
     *
     * @param string $message
     */
    public function info(string $message)
    {
        $this->controller->info($message);

        return;
    }

    /**
     * Runs controller process method
     *
     * @param array $replacement
     * @param array $filesMap
     *
     * @return int|void
     */
    public function process(array $replacement, array $filesMap)
    {
        $this->controller->replacement = $replacement;
        $this->controller->filesMap = $filesMap;

        try {
            return $this->controller->process();
        } catch (Exception $exception) {
            $this->controller->error($exception->getMessage());

            return ExitCode::OK;
        }
    }
}