<?php
declare(strict_types=1);

namespace Tailors\Tests\Lib\Context;

use PHPUnit\Framework\TestCase;
use Tailors\Lib\Context\ContextManagerInterface;
use Tailors\PHPUnit\ImplementsInterfaceTrait;

final class ContextManagerJ6I8B implements ContextManagerInterface
{
    use ContextManagerInterfaceTrait;
}

/**
 * @author Paweł Tomulik <pawel@tomulik.pl>
 *
 * @covers \Tailors\Tests\Lib\Context\ContextManagerInterfaceTrait
 *
 * @internal
 */
final class ContextManagerInterfaceTest extends TestCase
{
    use ImplementsInterfaceTrait;

    public static function createDummyInstance(): ContextManagerJ6I8B
    {
        return new ContextManagerJ6I8B();
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testDummyImplementation(): void
    {
        $dummy = $this->createDummyInstance();
        $this->assertImplementsInterface(ContextManagerInterface::class, $dummy);
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testEnterContext(): void
    {
        $dummy = $this->createDummyInstance();

        $dummy->enterContext = '';
        $this->assertSame($dummy->enterContext, $dummy->enterContext());
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testExitContext(): void
    {
        $dummy = $this->createDummyInstance();

        $dummy->exitContext = false;
        $this->assertSame($dummy->exitContext, $dummy->exitContext(new \Exception()));
        $this->assertSame($dummy->exitContext, $dummy->exitContext(null));
        $this->assertSame($dummy->exitContext, $dummy->exitContext());
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testExitContextWithArgTypeError(): void
    {
        $dummy = $this->createDummyInstance();

        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('?'.\Throwable::class);

        /** @psalm-suppress InvalidArgument */
        $dummy->exitContext('');
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testExitContextWithRetTypeError(): void
    {
        $dummy = $this->createDummyInstance();
        $dummy->exitContext = '';

        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('bool');
        $dummy->exitContext(new \Exception());
    }
}

// vim: syntax=php sw=4 ts=4 et:
