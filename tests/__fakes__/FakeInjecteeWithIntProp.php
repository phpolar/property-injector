<?php

declare(strict_types=1);

namespace Phpolar\PropertyInjector\Tests\Fakes;

use Phpolar\PropertyInjector\Inject;

final class FakeInjecteeWithIntProp
{
    #[Inject(self::DEPENDENCY_ID)]
    public int $propToInject;

    public const DEPENDENCY_ID = "FAKE_DEPENDENCY";
}
