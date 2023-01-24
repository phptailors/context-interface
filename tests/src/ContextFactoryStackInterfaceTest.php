<?php
declare(strict_types=1);

namespace Tailors\Tests\Lib\Context;

use PHPUnit\Framework\TestCase;
use Tailors\Lib\Context\ContextFactoryInterface;
use Tailors\Lib\Context\ContextFactoryStackInterface;
use Tailors\PHPUnit\ImplementsInterfaceTrait;

final class ContextFactoryStackL9LBE implements ContextFactoryStackInterface
{
    use ContextFactoryStackInterfaceTrait;
}

/**
 * @author Paweł Tomulik <pawel@tomulik.pl>
 *
 * @covers \Tailors\Tests\Lib\Context\ContextFactoryStackInterfaceTrait
 *
 * @internal
 */
final class ContextFactoryStackInterfaceTest extends TestCase
{
    use ImplementsInterfaceTrait;

    public static function createDummyInstance(): ContextFactoryStackL9LBE
    {
        return new ContextFactoryStackL9LBE();
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testDummyImplementation(): void
    {
        $dummy = $this->createDummyInstance();
        $this->assertImplementsInterface(ContextFactoryStackInterface::class, $dummy);
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testClean(): void
    {
        $dummy = $this->createDummyInstance();

        $this->assertNull($dummy->clean());
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testTop(): void
    {
        $dummy = $this->createDummyInstance();

        $dummy->top = $this->createStub(ContextFactoryInterface::class);
        $this->assertSame($dummy->top, $dummy->top());

        $dummy->top = null;
        $this->assertSame($dummy->top, $dummy->top());
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testTopWithTypeError(): void
    {
        $dummy = $this->createDummyInstance();
        $dummy->top = '';

        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('?'.ContextFactoryInterface::class);

        /** @psalm-suppress UnusedMethodCall */
        $dummy->top();
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testPush(): void
    {
        $dummy = $this->createDummyInstance();

        $push = $this->createStub(ContextFactoryInterface::class);
        $this->assertNull($dummy->push($push));
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testPushWithNull(): void
    {
        $dummy = $this->createDummyInstance();

        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage(ContextFactoryInterface::class);

        /** @psalm-suppress NullArgument */
        $dummy->push(null);
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testPop(): void
    {
        $dummy = $this->createDummyInstance();

        $dummy->pop = $this->createStub(ContextFactoryInterface::class);
        $this->assertSame($dummy->pop, $dummy->pop());

        $dummy->pop = null;
        $this->assertSame($dummy->pop, $dummy->pop());
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testPopWithTypeError(): void
    {
        $dummy = $this->createDummyInstance();
        $dummy->pop = '';

        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('?'.ContextFactoryInterface::class);

        /** @psalm-suppress UnusedMethodCall */
        $dummy->pop();
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testSize(): void
    {
        $dummy = $this->createDummyInstance();

        $dummy->size = 0;
        $this->assertSame($dummy->size, $dummy->size());
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testSizeWithNull(): void
    {
        $dummy = $this->createDummyInstance();
        $dummy->size = null;

        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('int');

        /** @psalm-suppress UnusedMethodCall */
        $dummy->size();
    }
}

// vim: syntax=php sw=4 ts=4 et:
