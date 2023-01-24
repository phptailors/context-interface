<?php declare(strict_types=1);

namespace Tailors\Lib\Context;

use PHPUnit\Framework\TestCase;
use Tailors\PHPUnit\ImplementsInterfaceTrait;

final class ExecutorFactory74XB4 implements ExecutorFactoryInterface
{
    use ExecutorFactoryInterfaceTrait;
}

/**
 * @author Paweł Tomulik <pawel@tomulik.pl>
 *
 * @covers \Tailors\Lib\Context\ExecutorFactoryInterfaceTrait
 *
 * @internal
 */
final class ExecutorFactoryInterfaceTest extends TestCase
{
    use ImplementsInterfaceTrait;

    public static function createDummyInstance(): ExecutorFactory74XB4
    {
        return new ExecutorFactory74XB4();
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testDummyImplementation(): void
    {
        $dummy = $this->createDummyInstance();
        $this->assertImplementsInterface(ExecutorFactoryInterface::class, $dummy);
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testWithContext(): void
    {
        $dummy = $this->createDummyInstance();
        $dummy->withContext = $this->createStub(ExecutorInterface::class);

        $context = [
            $this->createStub(ContextManagerInterface::class),
            $this->createStub(ContextManagerInterface::class),
            $this->createStub(ContextManagerInterface::class),
        ];

        $this->assertSame($dummy->withContext, $dummy->withContext());
        $this->assertSame($dummy->withContext, $dummy->withContext($context[0]));
        $this->assertSame($dummy->withContext, $dummy->withContext($context[0], $context[1]));
        $this->assertSame($dummy->withContext, $dummy->withContext($context[0], $context[1], $context[2]));
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testWithContextWithArgTypeError(): void
    {
        $dummy = $this->createDummyInstance();

        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage(ContextManagerInterface::class);

        /** @psalm-suppress InvalidArgument */
        $dummy->withContext('');
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testWithContextWithRetTypeError(): void
    {
        $dummy = $this->createDummyInstance();
        $dummy->withContext = '';

        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage(ExecutorInterface::class);
        $dummy->withContext();
    }
}

// vim: syntax=php sw=4 ts=4 et:
