<?php

declare(strict_types=1);

namespace Phpolar\PropertyInjector\Tests\Fakes;

use Phpolar\PropertyInjector\Inject;

final class FakeInjecteeWithPrivateProp
{
    #[Inject(self::DEPENDENCY_ID)]
    private string $propToInject;

    public const DEPENDENCY_ID = "FAKE_DEPENDENCY";
    public const NOT_SET_VALUE = "not set";

    public function getPropValue(): string
    {
        return $this->propToInject ?? self::NOT_SET_VALUE;
    }
}
