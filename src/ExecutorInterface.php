<?php
declare(strict_types=1);

namespace Tailors\Lib\Context;

/**
 * Interface for context managers.
 */
interface ExecutorInterface
{
    /**
     * Invokes user function.
     *
     * @param callable $func The user function to be called
     *
     * @return mixed the value returned by ``$func``
     *
     * @psalm-template ReturnType
     *
     * @psalm-param callable(...):ReturnType $func
     *
     * @psalm-return ReturnType
     */
    public function __invoke(callable $func): mixed;
}

// vim: syntax=php sw=4 ts=4 et:
