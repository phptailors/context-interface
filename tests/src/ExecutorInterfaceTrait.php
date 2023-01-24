<?php
declare(strict_types=1);

namespace Tailors\Tests\Lib\Context;

/**
 * @author Paweł Tomulik <pawel@tomulik.pl>
 */
trait ExecutorInterfaceTrait
{
    public mixed $invoke;

    public function __invoke(callable $func): mixed
    {
        return $this->invoke;
    }
}

// vim: syntax=php sw=4 ts=4 et:
