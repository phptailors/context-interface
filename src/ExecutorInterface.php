<?php

namespace Tailors\Lib\Context;

/**
 * Interface for context managers.
 *
 * @api
 */
interface ExecutorInterface
{
    /**
     * Invokes user function.
     *
     * @param callable $func The user function to be called
     *
     * @psalm-template ReturnType
     *
     * @psalm-param callable(...):ReturnType $func
     *
     * @return mixed the value returned by ``$func``
     *
     * @psalm-return ReturnType
     */
    public function do(callable $func): mixed;
}

// vim: syntax=php sw=4 ts=4 et:
