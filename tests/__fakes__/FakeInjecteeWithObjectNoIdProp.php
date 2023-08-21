<?php

declare(strict_types=1);

namespace Phpolar\PropertyInjector\Tests\Fakes;

use Phpolar\PropertyInjector\Inject;

final class FakeInjecteeWithObjectNoIdProp
{
    #[Inject]
    public FakeDependency $propToInject;
}
