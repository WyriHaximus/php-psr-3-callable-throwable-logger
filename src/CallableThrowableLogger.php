<?php declare(strict_types=1);

namespace WyriHaximus\PSR3\CallableThrowableLogger;

use Psr\Log\LoggerInterface;
use Throwable;

final class CallableThrowableLogger
{
    const MESSAGE = 'Uncaught Throwable %1$s: "%2$s" at %3$s line %4$s';

    public static function create(LoggerInterface $logger, string $level = 'error', string $message = self::MESSAGE): callable
    {
        return function (Throwable $throwable) use ($logger, $level, $message) {
            $logger->log(
                $level,
                \sprintf(
                    $message,
                    \get_class($throwable),
                    $throwable->getMessage(),
                    $throwable->getFile(),
                    $throwable->getLine()
                ),
                [
                    'exception' => $throwable,
                ]
            );
        };
    }
}
