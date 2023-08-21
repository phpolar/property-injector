<?php

declare(strict_types=1);

namespace Phpolar\PropertyInjector;

use Phpolar\PropertyInjector\Exception\IntersectionTypeException;
use Phpolar\PropertyInjector\Exception\InvalidAttributeConfigurationException;
use Phpolar\PropertyInjector\Exception\UnionTypeException;
use Phpolar\PropertyInjector\Tests\Fakes\FakeDependency;
use Phpolar\PropertyInjector\Tests\Fakes\FakeInjecteeWithNoIdIntersectionTypeProp;
use Phpolar\PropertyInjector\Tests\Fakes\FakeInjecteeWithNoIdNoTypeProp;
use Phpolar\PropertyInjector\Tests\Fakes\FakeInjecteeWithNoIdUnionTypeProp;
use Phpolar\PropertyInjector\Tests\Fakes\FakeInjecteeWithObjectNoIdProp;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

#[CoversClass(Inject::class)]
#[UsesClass(InvalidAttributeConfigurationException::class)]
final class InjectTest extends TestCase
{
    #[TestDox("Shall return the provided dependency id")]
    #[TestWith(["FAKE_ID_1"])]
    #[TestWith(["FAKE_ID_2"])]
    #[TestWith(["FAKE_ID_3"])]
    public function testa(string $dependencyId)
    {
        $sut = new Inject($dependencyId);

        $result = $sut->getId(new ReflectionProperty(FakeInjecteeWithObjectNoIdProp::class, "propToInject"));

        $this->assertSame($dependencyId, $result);
    }

    #[TestDox("Shall return the class name of the object when no id is provided")]
    public function testb()
    {
        $sut = new Inject();

        $result = $sut->getId(new ReflectionProperty(FakeInjecteeWithObjectNoIdProp::class, "propToInject"));

        $this->assertSame(FakeDependency::class, $result);
    }

    #[TestDox("Shall throw invalid attribute configuration when no id is provided and the property has no type hint")]
    public function testc()
    {
        $this->expectException(InvalidAttributeConfigurationException::class);
        $sut = new Inject();

        $sut->getId(new ReflectionProperty(FakeInjecteeWithNoIdNoTypeProp::class, "propToInject"));
    }

    #[TestDox("Shall throw invalid attribute configuration when no id is provided and the property has an intersection type")]
    public function testd()
    {
        $this->expectException(IntersectionTypeException::class);
        $sut = new Inject();

        $sut->getId(new ReflectionProperty(FakeInjecteeWithNoIdIntersectionTypeProp::class, "propToInject"));
    }

    #[TestDox("Shall throw invalid attribute configuration when no id is provided and the property has a union type")]
    public function teste()
    {
        $this->expectException(UnionTypeException::class);
        $sut = new Inject();

        $sut->getId(new ReflectionProperty(FakeInjecteeWithNoIdUnionTypeProp::class, "propToInject"));
    }
}
