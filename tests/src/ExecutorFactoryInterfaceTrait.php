<?php declare(strict_types=1);

namespace Tailors\Lib\Context;

/**
 * @author Paweł Tomulik <pawel@tomulik.pl>
 */
trait ExecutorFactoryInterfaceTrait
{
    public mixed $withContext = null;

    public function withContext(ContextManagerInterface ...$context): ExecutorInterface
    {
        return $this->withContext;
    }
}

// vim: syntax=php sw=4 ts=4 et:
