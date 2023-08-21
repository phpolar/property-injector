<?php

declare(strict_types=1);

namespace Phpolar\PropertyInjector;

use Psr\Container\ContainerInterface;
use ReflectionAttribute;
use ReflectionObject;
use ReflectionProperty;

/**
 * Sets public properties marked for injection.
 *
 * The injector will attempt to retrieve a
 * dependency from the provided PSR-11
 * contiainer using the dependency
 * identifier from the Inject attribute.
 */
final class PropertyInjector
{
    public function __construct(private ContainerInterface $container)
    {
    }

    /**
     * Attempts to inject the dependency into
     * the marked property using the configured
     * dependency id.
     */
    public function inject(object $injectee): void
    {
        foreach (
            (new ReflectionObject($injectee))->getProperties(ReflectionProperty::IS_PUBLIC) as $publicProperty
        ) {
            $injectAttribute = current($publicProperty->getAttributes(Inject::class));
            if ($injectAttribute instanceof ReflectionAttribute) {
                $publicProperty->setValue(
                    $injectee,
                    $this->container->get(
                        $injectAttribute->newInstance()->getId($publicProperty)
                    )
                );
            }
            // @codeCoverageIgnore
            // inject attributes cannot repeat
        }
    }
}
