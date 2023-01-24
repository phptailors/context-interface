<?php

namespace Tailors\Lib\Context;

/**
 * Interface for Context Manager service.
 */
interface ExecutorServiceInterface
{
    public function with(mixed ...$args): ExecutorInterface;
}

// vim: syntax=php sw=4 ts=4 et:
