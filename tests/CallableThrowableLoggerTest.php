<?php declare(strict_types=1);

namespace WyriHaximus\Tests\PSR3\CallableThrowableLogger;

use Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Throwable;
use WyriHaximus\PSR3\CallableThrowableLogger\CallableThrowableLogger;

final class CallableThrowableLoggerTest extends TestCase
{
    public function provideThrowables()
    {
        yield [new Exception('foo.bar')];
        yield [new CallableThrowableLoggerTestException('bar.foo')];
    }

    /**
     * @dataProvider provideThrowables
     */
    public function testCallable(Throwable $throwable)
    {
        $logger = $this->prophesize(LoggerInterface::class);
        $logger->log(
            'error',
            \sprintf(
                CallableThrowableLogger::MESSAGE,
                \get_class($throwable),
                $throwable->getMessage(),
                $throwable->getFile(),
                $throwable->getLine()
            ),
            [
                'exception' => $throwable,
            ]
        )->shouldBeCalled();

        $callable = CallableThrowableLogger::create($logger->reveal());
        $callable($throwable);
    }
}
