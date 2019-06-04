<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\extensions\maker\commands;

use app\extensions\console\Command;
use app\extensions\maker\actions\ApiAction;
use app\extensions\maker\actions\BehaviorAction;
use app\extensions\maker\actions\CommandAction;
use app\extensions\maker\actions\ComponentAction;
use app\extensions\maker\actions\ControllerAction;
use app\extensions\maker\actions\FilterAction;
use app\extensions\maker\actions\FormAction;
use app\extensions\maker\actions\JobAction;
use app\extensions\maker\actions\MailAction;
use app\extensions\maker\actions\MigrationAction;
use app\extensions\maker\actions\ModelAction;
use app\extensions\maker\actions\ModuleAction;
use app\extensions\maker\actions\QueryAction;
use app\extensions\maker\actions\ResourceAction;
use app\extensions\maker\actions\SeedAction;
use app\extensions\maker\actions\ServiceAction;
use app\extensions\maker\actions\ViewAction;
use app\extensions\maker\actions\WorkerAction;
use yii\helpers\FileHelper;

class MakeController extends Command
{
    /**
     * Directory to write files
     * @var string
     */
    public $baseDir;

    /**
     * Directory with templates files
     * @var string
     */
    public $templatesDir;

    /**
     * Key-value pairs to replace with content
     * @var array
     */
    public $replacement = [];

    /**
     * 'Original => destination' pairs to write files
     * @var array
     */
    public $filesMap = [];

    /**
     * Basic configuration of controller
     */
    public function init()
    {
        if (!$this->baseDir) {
            $this->baseDir = alias('@app');
        }

        if (!$this->templatesDir) {
            $this->templatesDir = dirname(__DIR__) . "/templates";
        }

        parent::init();
    }

    /**
     * @param string $id
     * @param array $params
     *
     * @return int
     * @throws \yii\base\InvalidRouteException
     * @throws \yii\console\Exception
     */
    public function runAction($id, $params = [])
    {
        return parent::runAction($id, $params);
    }

    /**
     * Generates new files
     * @throws \yii\base\Exception
     */
    public function process()
    {
        foreach ($this->filesMap as $source => $destination) {
            // build absolute file paths
            $originalFilePath = FileHelper::normalizePath("{$this->templatesDir}/{$source}");
            $destinationFilePath = FileHelper::normalizePath("{$this->baseDir}/{$destination}");

            // read content of a template file
            $content = stringy(file_get_contents($originalFilePath));

            // replace all values from '$replacement' array
            foreach ($this->replacement as $placeholder => $value) {
                $content = $content->replace("{{{$placeholder}}}", $value);
            }

            // write changes to the file
            if (!is_dir(dirname($destinationFilePath))) {
                FileHelper::createDirectory(dirname($destinationFilePath));
            }

            file_put_contents($destinationFilePath, $content);

            // show success message
            $this->info("Created: {$destinationFilePath}");
        }
    }

    /**
     * MakeController actions for scaffolding
     * @return array
     */
    public function actions()
    {
        return [
            // Controllers
            'controller' => ControllerAction::class,
            'command' => CommandAction::class,
            'worker' => WorkerAction::class,
            'resource' => ResourceAction::class,

            // Database
            'migration' => MigrationAction::class,
            'model' => ModelAction::class,
            'query' => QueryAction::class,
            'seeder' => SeedAction::class,

            // Core
            'behavior' => BehaviorAction::class,
            'component' => ComponentAction::class,
            'service' => ServiceAction::class,
            'filter' => FilterAction::class,
            'form' => FormAction::class,
            'job' => JobAction::class,
            'mail' => MailAction::class,
            'view' => ViewAction::class,

            // Modules
            'module' => ModuleAction::class,
            'api' => ApiAction::class,
        ];
    }
}