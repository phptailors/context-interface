<?php
declare(strict_types=1);

namespace Tailors\Tests\Lib\Context;

use PHPUnit\Framework\TestCase;
use Tailors\Lib\Context\ContextFactoryInterface;
use Tailors\Lib\Context\ContextManagerInterface;
use Tailors\PHPUnit\ImplementsInterfaceTrait;

final class ContextFactoryE4N3C implements ContextFactoryInterface
{
    use ContextFactoryInterfaceTrait;
}

/**
 * @author Paweł Tomulik <pawel@tomulik.pl>
 *
 * @covers \Tailors\Tests\Lib\Context\ContextFactoryInterfaceTrait
 *
 * @internal
 */
final class ContextFactoryInterfaceTest extends TestCase
{
    use ImplementsInterfaceTrait;

    public static function createDummyInstance(): ContextFactoryE4N3C
    {
        return new ContextFactoryE4N3C();
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testDummyImplementation(): void
    {
        $dummy = $this->createDummyInstance();
        $this->assertImplementsInterface(ContextFactoryInterface::class, $dummy);
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testGetContextManager(): void
    {
        $dummy = $this->createDummyInstance();

        $dummy->contextManager = $this->createStub(ContextManagerInterface::class);
        $this->assertSame($dummy->contextManager, $dummy->getContextManager(''));

        $dummy->contextManager = null;
        $this->assertSame($dummy->contextManager, $dummy->getContextManager(''));
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testGetContextManagerWithTypeError(): void
    {
        $dummy = $this->createDummyInstance();
        $dummy->contextManager = '';

        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('?'.ContextManagerInterface::class);
        $dummy->getContextManager('');
    }
}

// vim: syntax=php sw=4 ts=4 et:
