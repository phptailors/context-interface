<?php
declare(strict_types=1);

namespace Tailors\Lib\Context;

/**
 * A stack of instances implementing ContextFactoryInterface.
 */
interface ContextFactoryStackInterface
{
    /**
     * Resets the stack to empty state.
     */
    public function clean(): void;

    /**
     * Returns the factory from the top of stack or null if the stack is empty.
     */
    public function top(): ?ContextFactoryInterface;

    /**
     * Pushes the $factory to the top of stack.
     */
    public function push(ContextFactoryInterface $factory): void;

    /**
     * Pops and returns the factory from the top of stack shortening the array
     * of factories by one element.
     *
     * If the stack is empty, returns null
     */
    public function pop(): ?ContextFactoryInterface;

    /**
     * Returns the stack size.
     */
    public function size(): int;
}

// vim: syntax=php sw=4 ts=4 et:
