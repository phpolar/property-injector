<?php

declare(strict_types=1);

namespace Phpolar\PropertyInjector\Tests\Fakes;

use Phpolar\PropertyInjector\Inject;

final class FakeInjecteeWithNoIdIntersectionTypeProp
{
    #[Inject]
    public FakeDependency&Inject $propToInject;
}
