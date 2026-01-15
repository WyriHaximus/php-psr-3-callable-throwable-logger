<?php

declare(strict_types=1);

namespace WyriHaximus\PSR3\CallableThrowableLogger;

use Psr\Log\LoggerInterface;
use Throwable;

use function sprintf;

final class CallableThrowableLogger
{
    public const string MESSAGE = 'Uncaught Throwable %1$s: "%2$s" at %3$s line %4$s';

    /** @api */
    public static function create(LoggerInterface $logger, string $level = 'error', string $message = self::MESSAGE): callable
    {
        return static function (Throwable $throwable) use ($logger, $level, $message): void {
            /**
             * Ignoring this because we're just passing it a long
             *
             * @phpstan-ignore psr3.interpolated
             */
            $logger->log(
                $level,
                sprintf(
                    $message,
                    $throwable::class, // phpcs:disable
                    $throwable->getMessage(),
                    $throwable->getFile(),
                    $throwable->getLine()
                ),
                ['exception' => $throwable]
            );
        };
    }
}
