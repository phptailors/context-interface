<?php

namespace Tailors\Lib\Context;

/**
 * Interface for context service.
 *
 * @api
 */
interface ExecutorFactoryInterface
{
    /**
     * Provides an Executor for invoking user-provided function with $args.
     */
    public function withContext(ContextManagerInterface ...$context): ExecutorInterface;
}

// vim: syntax=php sw=4 ts=4 et:
