<?php

declare(strict_types=1);

namespace Phpolar\PropertyInjector;

use Attribute;
use Phpolar\PropertyInjector\Exception\IntersectionTypeException;
use Phpolar\PropertyInjector\Exception\InvalidAttributeConfigurationException;
use Phpolar\PropertyInjector\Exception\UnionTypeException;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionUnionType;

/**
 * An attribute used to mark a property
 * for automatic dependency injection.
 *
 * The injector will attempt to retrieve
 * the dependency from the container
 * using the provided dependency id
 * and set the target property.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class Inject
{
    /**
     * @param string $dependencyId
     *
     * The identifier used to register and retrieve a dependency
     * from the container.
     */
    public function __construct(
        private ?string $dependencyId = null,
    ) {
    }

    public function getId(ReflectionProperty $reflectionProperty): string
    {
        return $this->dependencyId ?? $this->getTypeName($reflectionProperty);
    }

    private function getTypeName(ReflectionProperty $reflectionProperty): string
    {
        $type = $reflectionProperty->getType();
        return match (true) {
            $type instanceof ReflectionNamedType => $type->getName(),
            $type instanceof ReflectionIntersectionType =>
                throw new IntersectionTypeException(),
            $type instanceof ReflectionUnionType =>
                throw new UnionTypeException(),
            default =>
                throw new InvalidAttributeConfigurationException(
                    "Either the property should have a type hint or the Inject attribute should have a
                    dependency id."
                ),
        };
    }
}
