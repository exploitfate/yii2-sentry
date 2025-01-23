<?php

namespace exploitfate\yii\sentry\handlers;

use Sentry\SentrySdk;
use Sentry\Tracing\TransactionContext;
use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\base\Event;
use yii\console\Application;

/**
 * Console Bootstrap handler for Sentry profiling
 */
class ConsoleHandler extends Component implements BootstrapInterface
{
    /**
     * @inheritDoc
     */
    public function bootstrap($app)
    {
        $app->on(
            Application::EVENT_BEFORE_REQUEST,
            /**
             * @param Event $event
             */
            function ($event) use ($app) {
                /** @var Application $app */
                $transactionContext = new TransactionContext();
                $transactionContext->setName('Command');
                $transactionContext->setOp('console.command');
                $transactionContext->setData([
                    'console.command.path' => $app->getRequest()->getPathInfo(),
                ]);

                $transaction = SentrySdk::getCurrentHub()->startTransaction($transactionContext);
            }
        );

        /**
         * @param Event $event
         * @return void
         */
        $app->on(
            Application::EVENT_AFTER_REQUEST,
            /**
             * @param Event $event
             */
            function ($event) use ($app) {
                /** @var Application $app */
                $transaction = SentrySdk::getCurrentHub()->getTransaction();
                if ($transaction !== null) {
                    $transaction->setHttpStatus($app->getResponse()->getStatusCode());
                    $transaction->finish();
                }
            }
        );
    }
}