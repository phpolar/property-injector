<?php

declare(strict_types=1);

namespace Phpolar\PropertyInjector\Exception;

/**
 * Automatic dependency injection does not support
 * union types when a dependency identifier
 * is not supplied.
 */
final class UnionTypeException extends InvalidAttributeConfigurationException
{
    public function __construct()
    {
        parent::__construct("Union types are invalid when no dependency id is provided.");
    }
}
