<?php

declare(strict_types=1);

namespace Phpolar\PropertyInjector\Exception;

/**
 * Automatic dependency injection does not support
 * intersection types when a dependency identifier
 * is not supplied.
 */
final class IntersectionTypeException extends InvalidAttributeConfigurationException
{
    public function __construct()
    {
        parent::__construct("Intersection types are invalid when no dependency id is provided.");
    }
}
