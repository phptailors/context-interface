<?php
declare(strict_types=1);

namespace Tailors\Tests\Lib\Context;

use Tailors\Lib\Context\ContextManagerInterface;

/**
 * @author Paweł Tomulik <pawel@tomulik.pl>
 */
trait ContextFactoryInterfaceTrait
{
    public mixed $contextManager;

    /**
     * @psalm-suppress MixedInferredReturnType
     */
    public function getContextManager(mixed $arg): ?ContextManagerInterface
    {
        return $this->contextManager;
    }
}

// vim: syntax=php sw=4 ts=4 et:
