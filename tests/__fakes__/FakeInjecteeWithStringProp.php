<?php

declare(strict_types=1);

namespace Phpolar\PropertyInjector\Tests\Fakes;

use Phpolar\PropertyInjector\Inject;

final class FakeInjecteeWithStringProp
{
    #[Inject(self::DEPENDENCY_ID)]
    public string $propToInject;

    public const DEPENDENCY_ID = "FAKE_DEPENDENCY";
}
