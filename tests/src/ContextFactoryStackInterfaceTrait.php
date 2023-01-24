<?php
declare(strict_types=1);

namespace Tailors\Tests\Lib\Context;

use Tailors\Lib\Context\ContextFactoryInterface;

/**
 * @author Paweł Tomulik <pawel@tomulik.pl>
 */
trait ContextFactoryStackInterfaceTrait
{
    public mixed $top;
    public mixed $pop;
    public mixed $size;

    public function clean(): void
    {
    }

    /** @psalm-suppress MixedInferredReturnType */
    public function top(): ?ContextFactoryInterface
    {
        return $this->top;
    }

    public function push(ContextFactoryInterface $factory): void
    {
    }

    /** @psalm-suppress MixedInferredReturnType */
    public function pop(): ?ContextFactoryInterface
    {
        return $this->pop;
    }

    /** @psalm-suppress MixedInferredReturnType */
    public function size(): int
    {
        return $this->size;
    }
}

// vim: syntax=php sw=4 ts=4 et:
