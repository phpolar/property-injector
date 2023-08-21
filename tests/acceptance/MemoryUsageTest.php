<?php

declare(strict_types=1);

namespace Phpolar\Phpolar;

use Phpolar\PropertyInjector\PropertyInjector;
use Phpolar\PropertyInjector\Tests\Fakes\FakeInjecteeWithStringProp;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

use const \Phpolar\PropertyInjector\Tests\PROJECT_MEMORY_USAGE_THRESHOLD;

#[CoversNothing]
final class MemoryUsageTest extends TestCase
{
    #[Test]
    #[TestDox("Memory usage for a get request shall be below " . PROJECT_MEMORY_USAGE_THRESHOLD . " bytes")]
    public function shallBeBelowThreshold1()
    {
        $fakeInjectee = new FakeInjecteeWithStringProp();
        /**
         * @var ContainerInterface&MockObject
         */
        $mockContainer = $this->createMock(ContainerInterface::class);
        $mockContainer->method("get")
            ->with($fakeInjectee::DEPENDENCY_ID)
            ->willReturn("FAKE_DEPENDENCY");

        $totalUsed = -memory_get_usage();

        (new PropertyInjector($mockContainer))->inject($fakeInjectee);

        $totalUsed += memory_get_usage();
        $this->assertGreaterThan(0, $totalUsed);
        $this->assertLessThanOrEqual((int) PROJECT_MEMORY_USAGE_THRESHOLD, $totalUsed);
    }
}
