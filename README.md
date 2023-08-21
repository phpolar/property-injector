<p align="center">
    <img width="240" src="./phpolar.svg" />
</p>

# Property Injector

## Provides automatic dependency injection for properties.

[![Coverage Status](https://coveralls.io/repos/github/phpolar/property-injector/badge.svg?branch=main)](https://coveralls.io/repos/github/phpolar/property-injector/badge.svg?branch=main) ![Latest Stable Version](http://poser.pugx.org/phpolar/property-injector/v) ![Total Downloads](http://poser.pugx.org/phpolar/property-injector/downloads) ![Latest Unstable Version](http://poser.pugx.org/phpolar/property-injector/v/unstable) ![License](http://poser.pugx.org/phpolar/property-injector/license) ![PHP Version Require](http://poser.pugx.org/phpolar/property-injector/require/php) [![PHP Build Latest and Nightly](https://github.com/phpolar/property-injector/actions/workflows/php-latest.yml/badge.svg)](https://github.com/phpolar/property-injector/actions/workflows/php-latest.yml) [![PHPMD](https://github.com/phpolar/property-injector/actions/workflows/phpmd.yml/badge.svg)](https://github.com/phpolar/property-injector/actions/workflows/phpmd.yml)

## Quick Start

```php
class Example1
{
    /**
     * Will set this property with the
     * value in the DI container
     * that is registered with 'DEPENDENCY_ID'
     */
    #[Inject("DEPENDENCY_ID")]
    public string $property;
}

class Example2
{
    /**
     * Will set this property with the
     * value in the DI container
     * that is registered with the claass name
     * in the type hint
     */
    #[Inject]
    public SomeDependency $property;
}

class Example3
{
    /**
     * Will ignore protected properties.
     */
    #[Inject]
    protected SomeDependency $property;

    /**
     * Will ignore private properties.
     */
    #[Inject]
    private SomeDependency $property;
}

$injectee = new Example1();
(new PropertyInjector($psr11Container))->inject($injectee);

$injectee->property === $psr11Container->get("DEPENDENCY_ID"); // true
```
