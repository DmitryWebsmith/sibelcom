<?php

namespace App\Services;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LoggerService
{
    const INFO_LEVEL = 'INFO';
    const ERROR_LEVEL = 'ERROR';

    public function log($message, array $context = [], string $level = self::INFO_LEVEL): void
    {
        $logger = new Logger('name');
        $logPath = dirname(__DIR__, 2) . '/storage/logs/log.log';
        $logger->pushHandler(new StreamHandler($logPath));

        if ($level === self::INFO_LEVEL) {
            $logger->info($message, $context);
        } elseif ($level === self::ERROR_LEVEL) {
            $logger->error($message, $context);
        } else {
            $logger->warning($message, $context);
        }
    }
}