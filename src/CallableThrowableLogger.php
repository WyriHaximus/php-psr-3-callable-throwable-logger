<?php declare(strict_types=1);

namespace WyriHaximus\PSR3\CallableThrowableLogger;

use Psr\Log\LoggerInterface;
use Throwable;

final class CallableThrowableLogger
{
    const MESSAGE = 'Uncaught Throwable %s: "%s" at %s line %s';

    public static function create(LoggerInterface $logger, string $level = 'error'): callable
    {
        return function (Throwable $throwable) use ($logger, $level) {
            $logger->log(
                $level,
                \sprintf(
                    self::MESSAGE,
                    \get_class($throwable),
                    $throwable->getMessage(),
                    $throwable->getFile(),
                    $throwable->getLine()
                ),
                [
                    'throwable' => $throwable,
                ]
            );
        };
    }
}
