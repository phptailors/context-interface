<?php
declare(strict_types=1);

namespace Tailors\Lib\Context;

/**
 * Interface for context managers.
 */
interface ContextFactoryInterface
{
    /**
     * @param mixed $arg an argument to be turned into a context manager
     *
     * @return ContextManagerInterface
     */
    public function getContextManager(mixed $arg): ?ContextManagerInterface;
}

// vim: syntax=php sw=4 ts=4 et:
