<?php declare(strict_types=1);

namespace Tailors\Lib\Context;

use PHPUnit\Framework\TestCase;
use Tailors\PHPUnit\ImplementsInterfaceTrait;

final class ExecutorB2L09 implements ExecutorInterface
{
    use ExecutorInterfaceTrait;
}

/**
 * @author Paweł Tomulik <pawel@tomulik.pl>
 *
 * @covers \Tailors\Lib\Context\ExecutorInterfaceTrait
 *
 * @internal
 */
final class ExecutorInterfaceTest extends TestCase
{
    use ImplementsInterfaceTrait;

    public static function createDummyInstance(): ExecutorB2L09
    {
        return new ExecutorB2L09();
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testDummyImplementation(): void
    {
        $dummy = $this->createDummyInstance();
        $this->assertImplementsInterface(ExecutorInterface::class, $dummy);
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testDo(): void
    {
        $dummy = $this->createDummyInstance();

        $dummy->do = '';
        $this->assertSame($dummy->do, $dummy->do(function () {}));
    }

    /**
     * @psalm-suppress MissingThrowsDocblock
     */
    public function testDoWithTypeError(): void
    {
        $dummy = $this->createDummyInstance();

        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('callable');
        $dummy->do('');
    }
}

// vim: syntax=php sw=4 ts=4 et:
