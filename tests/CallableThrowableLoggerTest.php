<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\PSR3\CallableThrowableLogger;

use Exception;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Psr\Log\LoggerInterface;
use Throwable;
use WyriHaximus\PSR3\CallableThrowableLogger\CallableThrowableLogger;
use WyriHaximus\TestUtilities\TestCase;

use function sprintf;

final class CallableThrowableLoggerTest extends TestCase
{
    /** @return iterable<array<int, Throwable>> */
    public static function provideThrowables(): iterable
    {
        yield [new Exception('foo.bar')];
        yield [new CallableThrowableLoggerTestException('bar.foo')];
    }

    #[DataProvider('provideThrowables')]
    #[Test]
    public function callable(Throwable $throwable): void
    {
        $logger = Mockery::mock(LoggerInterface::class);
        $logger->expects('log')->with(
            'error',
            sprintf(
                CallableThrowableLogger::MESSAGE,
                $throwable::class, // phpcs:disable
                $throwable->getMessage(),
                $throwable->getFile(),
                $throwable->getLine()
            ),
            ['exception' => $throwable]
        )->atLeast()->once();

        $callable = CallableThrowableLogger::create($logger);
        $callable($throwable);
    }
}
