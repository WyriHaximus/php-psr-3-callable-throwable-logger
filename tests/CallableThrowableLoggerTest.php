<?php

declare(strict_types=1);

namespace WyriHaximus\Tests\PSR3\CallableThrowableLogger;

use Exception;
use Psr\Log\LoggerInterface;
use Throwable;
use WyriHaximus\PSR3\CallableThrowableLogger\CallableThrowableLogger;
use WyriHaximus\TestUtilities\TestCase;

use function get_class;
use function Safe\sprintf;

final class CallableThrowableLoggerTest extends TestCase
{
    /**
     * @return iterable<array<int, Throwable>>
     */
    public function provideThrowables(): iterable
    {
        yield [new Exception('foo.bar')];
        yield [new CallableThrowableLoggerTestException('bar.foo')];
    }

    /**
     * @dataProvider provideThrowables
     */
    public function testCallable(Throwable $throwable): void
    {
        $logger = $this->prophesize(LoggerInterface::class);
        $logger->log(
            'error',
            sprintf(
                CallableThrowableLogger::MESSAGE,
                get_class($throwable),
                $throwable->getMessage(),
                $throwable->getFile(),
                $throwable->getLine()
            ),
            ['exception' => $throwable]
        )->shouldBeCalled();

        $callable = CallableThrowableLogger::create($logger->reveal());
        $callable($throwable);
    }
}
