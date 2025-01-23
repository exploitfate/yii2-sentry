<?php

namespace exploitfate\yii\sentry;

use exploitfate\yii\sentry\handlers\BaseHandler;
use exploitfate\yii\sentry\handlers\ConsoleHandler;
use exploitfate\yii\sentry\handlers\WebHandler;
use yii\base\BootstrapInterface;
use yii\base\Component;

/**
 * Sentry Bootstrap profiler
 */
class Sentry extends Component implements BootstrapInterface
{
    /**
     * @var bool Enable Sentry profiler
     */
    public $enabled = false;

    /**
     * @var array $options Sentry options. `dsn` required.
     * @see \Sentry\init()
     */
    public $options = [];

    /**
     * @inheritDoc
     */
    public function bootstrap($app)
    {
        if ($this->enabled) {
           if ($app instanceof \yii\web\Application) {
               $handler = new WebHandler();
           } elseif ($app instanceof \yii\console\Application) {
               $handler = new ConsoleHandler();
           } else {
               $handler = new BaseHandler();
           }
           $handler->bootstrap($app);
        }
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->enabled) {
            \Sentry\init($this->options);
        }
    }
}