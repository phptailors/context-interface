<?php declare(strict_types=1);

namespace Tailors\Lib\Context;

/**
 * @author Paweł Tomulik <pawel@tomulik.pl>
 */
trait ExecutorInterfaceTrait
{
    public mixed $do = null;

    public function do(callable $func): mixed
    {
        return $this->do;
    }
}

// vim: syntax=php sw=4 ts=4 et:
