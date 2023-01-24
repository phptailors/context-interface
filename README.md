[![PHPUnit](https://github.com/phptailors/context-interface/actions/workflows/phpunit.yml/badge.svg)](https://github.com/phptailors/context-interface/actions/workflows/phpunit.yml)
[![Composer Require Checker](https://github.com/phptailors/context-interface/actions/workflows/composer-require-checker.yml/badge.svg)](https://github.com/phptailors/context-interface/actions/workflows/composer-require-checker.yml)
[![BC Check](https://github.com/phptailors/context-interface/actions/workflows/backward-compatibility-check.yml/badge.svg)](https://github.com/phptailors/context-interface/actions/workflows/backward-compatibility-check.yml)
[![Psalm](https://github.com/phptailors/context-interface/actions/workflows/psalm.yml/badge.svg)](https://github.com/phptailors/context-interface/actions/workflows/psalm.yml)
[![PHP CS Fixer](https://github.com/phptailors/context-interface/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/phptailors/context-interface/actions/workflows/php-cs-fixer.yml)

<a name="ContextInterfaceLib"></a>
Context Manager Interfaces
==========================

A set of PHP interfaces that support implementation of Context Managers.

<a name="Introduction"></a>
## Introduction

The concept of Context Managers is borrowed from Python
([contextlib][py-contextlib], [with statement][py-with-stmt])
and [PHP RFC:  Context Managers][php-ctx-rfc].

Context Managers provide a way to abstract out common control-flow and
variable-lifetime-management patterns, leading to simplified business logic
code that can skip over a great deal of boilerplate. They place certain *guards
around a section of code*, such that certain behaviors are guaranteed upon
entering and leaving that section.

Commmon use cases include file management and database transactions, althrough
there are many more.

PHP 8 does not provide Context Managers natively, but there is
a [proposal][php-ctx-rfc] and a [pull request][php-ctx-pr] for the feature,
so it may appear in future versions. As for the time of this writting (March,
2026), the [RFC][php-ctx-rfc] has status "In Discussion".

This specification defines PHP interfaces, which may be used to implement
Context Managers in PHP 8. An implementation will be referred to as a
**library** through the rest of this document.

<a name="Specification"></a>
## 1. Specification

This specification defines four PHP interfaces. The first three formalize the
core of the Context Managers concept. The fourth is a convenience interface.

- [Core Interfaces](#CoreInterfaces)
- [Convenience Interfaces](#ConvenienceInterfaces)

<a name="CoreInterfaces"></a>
### 1.1 Core Interfaces

The three core interfaces are

- [ExecutorInterface](#ExecutorInterface)
- [ExecutorFactoryInterface](#ExecutorFactoryInterface)
- [ContextManagerInterface](#ContextManagerInterface)

With these three interfaces implemented, an application shall be able to use the
following syntax to execute a function with Context Managers in action:
```php
/** @var ExecutorFactoryInterface $executor */
$executor->withContext([C1[, C2[, ...]]])->do(
    function ([$arg1,[ $arg2[, ...]]]) {
        /* code */
    }
);
```
The ``C1``, ``C2``, ``...`` are expressions, each of which MUST evaluate to
an instance of [ContextManagerInterface](#ContextManagerInterface).

Using the above syntax, a cannonical example &mdash; a code for robust file handling
that includes all necessary error management and automatic cleanup &mdash; could be
written as follows:
```php
/** @var ExecutorFactoryInterface $executor */
$line = $executor->withContext(new FileContextManager(fopen("foo.txt", "rt")))->do(
    function (mixed $handle): string {
        return fgets($handle);
    }
);
```
with ``FileContextManger`` being an implementation of
[ContextManagerInterface](#ContextManagerInterface), such as
```php
readonly class FileContextManager implements ContextMangerInterface {
    private mixed $handle;

    public function __construct(mixed $handle) {
        $this->handle = $handle;
    }

    public function enterContext(): mixed {
        return $this->handle;
    }

    public function exitContext(?\Throwable $exception): ?\Throwable {
        fclose($this->handle);
        return $exception;
    }
}
```

<a name="ConvenienceInterfaces"></a>
### 1.2 Convenience Interfaces

The convenience interfaces include
- [ExecutorServiceInterface](#ExecutorServiceInterface)

The [ExecutorServiceInterface](#ExecutorServiceInterface) is a more abstract
version of the [ExecutorFactoryInterface](#ExecutorFactoryInterface). It
reduces the boilerplate required for wrapping Context Values with
[ContextManagers](#ContextManager). The syntax introduced by
[ExecutorServiceInterface](#ExecutorServiceInterface) is
```php
/** @var ExecutorServiceInterface $executor */
$executor->with([V1[, V2[, ...]]])->do(
    function ([$arg1[, $arg2[, ...]]]) {
        /* code */
    }
);
```
The ``V1``, ``V2``, ``...`` are expressions, each of which evaluates to an
arbitrary value, called a **Context Value**. It's the responsibility of
[ExecutorService](#ExecutorService) to wrap the provided **Context Values**
with appropriate [ContextManagers](#ContextManager).

With the above syntax, the cannonical example (robust file handling) would look
like follows:
```php
/** @var ExecutorServiceInterface $executor */
$line = $executor->with(fopen("foo.txt", "rb"))->do(
    function (mixed $handle): string {
        return fgets($handle);
    }
);
```
The difference is, that there is no call to ``new FileContextManager(...)`` in
the above snippet.

<a name="ExecutorFactory"></a>
### 1.3 ExecutorFactory

An implementing class for the
[ExecutorFactoryInterface](#ExecutorFactoryInterface) will be called
[ExecutorFactory](#ExecutorFactory) across this document, although implementors
may chose a different name. A minimal implementation of the
[ExecutorFactoryInterface](#ExecutorFactoryInterface) may look like:
```php
use Taylors\Context\ExecutorFactoryInterface;
use Taylors\Context\ExecutorInterface;

final class ExecutorFactory implements ExecutorFactoryInterface {
    public function withContext(ContextManagerInterface ...$context): ExecutorInterface {
        return new Executor($context);
    }
}
```
provided there is a class [Executor](#Executor) that implements the
[ExecutorInterface](#ExecutorInterface):

The purpose of the [ExecutorFactory](#ExecutorFactory) is to expose the
[withContext()](#withContext) method, which is an entry point similar to
the [using][php-ctx-rfc] keyword from the [PHP RFC][php-ctx-rfc].

<a name="withContext"></a>
#### 1.3.1 ExecutorFactory &mdash; the ``withContext()`` method

The [withContext()](#withContext) method of [ExecutorFactory](#ExecutorFactory) returns an
[Executor](#Executor) which adds the behavior specified by Context Managers to
the execution of a user-provided callback. The returned [Executor](#Executor)
MUST have access to the [ContextManagers](#ContextManager) passed as
``...$context`` to the [withContext()](#withContext) method.

<a name="Executor"></a>
### 1.4 Executor

An implementing class of the [ExecutorInterface](#ExecutorInterface) will be
called [Executor](#Executor) across this document, although implementors may
chose a different name.

The [Executor](#Executor) is coupled with a **\$context** &mdash; an ordered
collection of zero or more [ContextManagers](#ContextManager). The
**\$context** is supposed to be (created out of) the array of
``...$context`` arguments passed to [ExecutorFactory::withContext()](#withContext).
It must preserve element order and keys of ``...$context``.

In a nutshell, the [Executor](#Executor) invokes a user-provided callback
``$func`` within [Executor's](#Executor) **\$context** &mdash; it calls
[enterContext()](#enterContext) on all the [ContextManagers](#ContextManager)
from **\$context**, then executes the user-provided callback ``$func``, and
then calls [exitContext()](#exitContext) on all the
[ContextManagers](#ContextManager) in **\$context**.

An implementation must ensure, that using [Executor](#Executor) with multiple
[ContextManagers](#ContextManager) is equivalent to nesting
[Executors](#Executors) with consecutive [ContextManagers](#ContextManager)
from the same ``...$context``, i.e. the effect of
```php
/** @var ExecutorFactoryInterface */
$executor->withContext(E1, E2)->do(
    function ($arg1, $arg2) {
        /* code */
    }
);
```
is same as for
```php
/** @var ExecutorFactoryInterface */
$executor->withContext(E1)->do(
    function ($arg1) use ($executor) {
        return $executor->withContext(E2)->do(
            function ($arg2) use ($arg1) {
                /* code */
            }
        );
    }
);
```


<a name="do"></a>
#### 1.4.1 Executor &mdash; the ``do()`` method

An implementation of [ExecutorInterface::do()](#do), when invoked with a callable ``$func``, MUST:
1. invoke [enterContext()](#enterContext) on each [Context
   Manager](#ContextManager) from ``$context`` in original order, and collect
   returned values, then
2. invoke user-provided function ``$func`` passing it the values collected in 1
   as arguments, and then
3. invoke [exitContext()](#exitContext) on each [Context
   Manager](#ContextManager) from [Context](#Context) in reverse order,
4. return the value returned by ``$func``.

If an exception is thrown during iteration 1:

- the method MUST NOT invoke ``$func`` and MUST proceed to 3.

In addition, if an exception is thrown during iteration 1 or from ``$func``

- the reverse iteration in 3 MUST start from the last
  [ContextManager](#ContextManager) successfully visited in 1,
- if any of the [ContextManagers](#ContextManager) visited in 3 returns
  ``null``, the [Executor](#Executor) MUST return ``null`` without throwing,
- otherwise, if all [ContextManagers](#ContextManager) returned
  ``\Throwable``, the method MUST rethrow the exception returned by last
  visited [ContextManager](#ContextManager).

If any of the [ContextManagers](#ContextManager) returned ``null`` during
the reverse iteration 3, the exception is assumed handled by that
[ContextManager](#ContextManager) and is not passed to the remaining
[ContextManagers](#ContextManager).

An example implementation of [Executor::do()](#do) may look like follows:
```php
class Executor implements ExecutorInterface {
    /**
     * @var array<ContextManagerInterface>
     */
    private array $context;

    /* ... */

    public function do(callable $func): mixed
    {
        $exception = null;
        $return = null;
        $entered = [];

        try {
            $args = [];
            foreach ($this->context as $name => $manager) {
                $args[$name] = $manager->enterContext();
                $entered[] = $manager;
            }
            $return = call_user_func_array($func, $args);
        } catch(\Throwable $e) {
            $exception = $e;
        }

        while (count($entered) > 0) {
            $manager = array_pop($entered);
            if (null === $exception) {
                $manager->exitContext();
            } else {
                $exception = $manager->exitContext($exception);
            }
        }

        return $return;
    }
}
```

<a name="ContextManager"></a>
### 1.4 ContextManager

An implementing class of the
[ContextManagerInterface](#ContextManagerInterface) will be called
[ContextManager](#ContextManager) across this document, although implementors
may chose different names.

A [ContextManager](#ContextManager) object implements
[enterContext()](#enterContext) and [exitContext()](#exitContext) for a single
**Context Value**. In a typical scenario, multiple classes implementing
[ContextManageInterface](#ContextManageInterface) will be provided by a
**library** to handle e.g. different value types.

<a name="enterContext"></a>
#### 1.4.1 ContextManager &mdash; the ``enterContext()`` method

Enter the runtime context related to this object. The returned value will be
passed by [Executor](#Executor) to an appropriate argument of the user-provide
callback.

In most circumstances, the method returns the wrapped **Context Value** or a
value derived from it.

<a name="exitContext"></a>
#### 1.4.2 ContextManager &mdash; the ``exitContext()`` method

Exit the runtime context related to this object.

For a successful case, the [exitContext()](#exitContext) is called with no
arguments. It may take arbitrary cleanup steps, and its return value if any is
ignored.

If an exception is thrown in the course of the context block that propagates up
to the context block, this is considered a failure. The
[exitContext()](#exitContext) method is called with the exception as its only
parameter. If [exitContext()](#exitContext) returns ``null``, then no further
action is taken. If [exitContext()](#exitContext) returns a ``\Throwable``
(either the one it was passed or a new one), it will be rethrown.
[exitContext()](#exitContext) should NOT throw its own exceptions unless there
is an error with the context manager object itself.

Becausu in a success case the method is passed ``null``, that means always
calling ``return $exception`` will result in the desired in-most-cases behavior
(that is, rethrowing an exception if there was one, or just continuing if not).

<a name="Package"></a>
## 2. Package

The interfaces described are provided as part of the
[phptailors/context-interface](https://packagist.org/packages/phptailors/context-interface)
package.

<a name="ExecutorInterface"></a>
## 3. `ExecutorInterface`
```php
namespace Tailors\Lib\Context;

interface ExecutorInterface
{
    public function do(callable $func): mixed;
}
```

<a name="ExecutorFactoryInterface"></a>
## 4. `ExecutorFactoryInterface`

```php
namespace Tailors\Lib\Context;

interface ExecutorFactoryInterface
{
    public function withContext(ContextManagerInterface ...$context): ExecutorInterface;
}
```

<a name="ContextManagerInterface"></a>
## 5. `ContextManagerInterface`

```php
namespace Tailors\Lib\Context;

interface ContextManagerInterface
{
    public function enterContext(): mixed;
    public function exitContext(?\Throwable $exception): ?\Throwable;
}
```

<a name="ExecutorServiceInterface"></a>
## 6. `ExecutorServiceInterface`
```php
namespace Tailors\Lib\Context;
interface ExecutorServiceInterface
{
    public function with(mixed ...$args): ExecutorInterface;
}
```

<a name="References"></a>
## 8. References

- [Python: contextlib &mdash; Utilities for with-statement contexts][py-contextlib]
- [Python: the with statement][py-with-stmt]
- [PHP RFC: Context Managers][php-ctx-rfc]

[php-ctx-rfc]: <https://wiki.php.net/rfc/context-managers>
[php-ctx-pr]: <https://github.com/arnaud-lb/php-src/pull/26>
[py-contextlib]: <https://docs.python.org/library/contextlib.html>
[py-with-stmt]: <https://docs.python.org/reference/compound_stmts.html#with>
