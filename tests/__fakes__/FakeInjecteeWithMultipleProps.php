<?php

declare(strict_types=1);

namespace Phpolar\PropertyInjector\Tests\Fakes;

use Phpolar\PropertyInjector\Inject;

final class FakeInjecteeWithMultipleProps
{
    public const DEPENDENCY_ID_1 = "FAKE_DEPENDENCY_1";
    public const DEPENDENCY_ID_2 = "FAKE_DEPENDENCY_2";
    public const DEPENDENCY_ID_3 = "FAKE_DEPENDENCY_3";

    #[Inject(self::DEPENDENCY_ID_1)]
    public string $propToInject1;

    #[Inject(self::DEPENDENCY_ID_2)]
    public string $propToInject2;

    #[Inject(self::DEPENDENCY_ID_3)]
    public string $propToInject3;
}
