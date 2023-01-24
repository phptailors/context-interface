<?php declare(strict_types=1);

namespace Tailors\Lib\Context;

/**
 * @author Paweł Tomulik <pawel@tomulik.pl>
 */
trait ContextManagerInterfaceTrait
{
    public mixed $enterContext = null;
    public mixed $exitContext = null;

    public function enterContext(): mixed
    {
        return $this->enterContext;
    }

    public function exitContext(?\Throwable $exception = null): ?\Throwable
    {
        return $this->exitContext;
    }
}

// vim: syntax=php sw=4 ts=4 et:
