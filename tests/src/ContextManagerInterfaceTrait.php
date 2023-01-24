<?php
declare(strict_types=1);

namespace Tailors\Tests\Lib\Context;

/**
 * @author Paweł Tomulik <pawel@tomulik.pl>
 */
trait ContextManagerInterfaceTrait
{
    public mixed $enterContext;
    public mixed $exitContext;

    public function enterContext(): mixed
    {
        return $this->enterContext;
    }

    /** @psalm-suppress MixedInferredReturnType */
    public function exitContext(\Throwable $exception = null): bool
    {
        return $this->exitContext;
    }
}

// vim: syntax=php sw=4 ts=4 et:
