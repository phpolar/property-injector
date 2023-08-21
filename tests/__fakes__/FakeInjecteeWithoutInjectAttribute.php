<?php

declare(strict_types=1);

namespace Phpolar\PropertyInjector\Tests\Fakes;

final class FakeInjecteeWithoutInjectAttribute
{
    public string $propToInject;

    public const NOT_SET_VALUE = "not set";

    public function getPropValue(): string
    {
        return $this->propToInject ?? self::NOT_SET_VALUE;
    }
}
