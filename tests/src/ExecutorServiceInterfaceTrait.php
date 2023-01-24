<?php declare(strict_types=1);

namespace Tailors\Lib\Context;

/**
 * @author Paweł Tomulik <pawel@tomulik.pl>
 */
trait ExecutorServiceInterfaceTrait
{
    public mixed $with = null;

    public function with(mixed ...$args): ExecutorInterface
    {
        return $this->with;
    }
}

// vim: syntax=php sw=4 ts=4 et:
