<?php declare(strict_types=1);

namespace Tailors\Lib\Context;

use PHPUnit\Framework\TestCase;
use Tailors\PHPUnit\ImplementsInterfaceTrait;

final class ExecutorServiceA98DB implements ExecutorServiceInterface
{
    use ExecutorServiceInterfaceTrait;
}

/**
 * @author Paweł Tomulik <pawel@tomulik.pl>
 *
 * @covers \Tailors\Lib\Context\ExecutorServiceInterfaceTrait
 *
 * @internal
 */
final class ExecutorServiceInterfaceTest extends TestCase
{
    use ImplementsInterfaceTrait;

    public static function createDummyInstance(): ExecutorServiceA98DB
    {
        return new ExecutorServiceA98DB();
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testDummyImplementation(): void
    {
        $dummy = $this->createDummyInstance();
        $this->assertImplementsInterface(ExecutorServiceInterface::class, $dummy);
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testWith(): void
    {
        $dummy = $this->createDummyInstance();
        $dummy->with = $this->createStub(ExecutorInterface::class);

        $args = [null, 1, 'two'];

        $this->assertSame($dummy->with, $dummy->with());
        $this->assertSame($dummy->with, $dummy->with($args[0]));
        $this->assertSame($dummy->with, $dummy->with($args[0], $args[1]));
        $this->assertSame($dummy->with, $dummy->with($args[0], $args[1], $args[2]));
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testWithWithRetTypeError(): void
    {
        $dummy = $this->createDummyInstance();
        $dummy->with = '';

        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage(ExecutorInterface::class);
        $dummy->with();
    }
}

// vim: syntax=php sw=4 ts=4 et:
