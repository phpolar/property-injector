<?php

declare(strict_types=1);

namespace Phpolar\PropertyInjector;

use Phpolar\PropertyInjector\Tests\Fakes\FakeDependency;
use Phpolar\PropertyInjector\Tests\Fakes\FakeInjecteeWithIntProp;
use Phpolar\PropertyInjector\Tests\Fakes\FakeInjecteeWithMultipleProps;
use Phpolar\PropertyInjector\Tests\Fakes\FakeInjecteeWithObjectProp;
use Phpolar\PropertyInjector\Tests\Fakes\FakeInjecteeWithoutInjectAttribute;
use Phpolar\PropertyInjector\Tests\Fakes\FakeInjecteeWithPrivateProp;
use Phpolar\PropertyInjector\Tests\Fakes\FakeInjecteeWithProtectedProp;
use Phpolar\PropertyInjector\Tests\Fakes\FakeInjecteeWithStringProp;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

#[CoversClass(PropertyInjector::class)]
#[UsesClass(Inject::class)]
final class PropertyInjectorTest extends TestCase
{
    #[TestDox("Shall set an uninitialized, public property with a string value marked with the inject attribute")]
    #[TestWith(["STRING_ONE"])]
    #[TestWith(["STRING_TWO"])]
    public function testa(string $expectedString)
    {
        $fakeInjectee = new FakeInjecteeWithStringProp();
        /**
         * @var ContainerInterface&MockObject
         */
        $mockContainer = $this->createMock(ContainerInterface::class);
        $mockContainer->method("get")
            ->with($fakeInjectee::DEPENDENCY_ID)
            ->willReturn($expectedString);
        $sut = new PropertyInjector($mockContainer);

        $sut->inject($fakeInjectee);

        $this->assertSame($expectedString, $fakeInjectee->propToInject);
    }

    #[TestDox("Shall set an uninitialized, public property with an integer value marked with the inject attribute")]
    #[TestWith([PHP_INT_MIN])]
    #[TestWith([PHP_INT_MAX])]
    public function testaa(int $expectedInt)
    {
        $fakeInjectee = new FakeInjecteeWithIntProp();
        /**
         * @var ContainerInterface&MockObject
         */
        $mockContainer = $this->createMock(ContainerInterface::class);
        $mockContainer->method("get")
            ->with($fakeInjectee::DEPENDENCY_ID)
            ->willReturn($expectedInt);
        $sut = new PropertyInjector($mockContainer);

        $sut->inject($fakeInjectee);

        $this->assertSame($expectedInt, $fakeInjectee->propToInject);
    }

    #[TestDox("Shall set an uninitialized, public property with an object value marked with the inject attribute")]
    public function testb()
    {
        $givenDependency = new FakeDependency();
        $fakeInjectee = new FakeInjecteeWithObjectProp();
        /**
         * @var ContainerInterface&MockObject
         */
        $mockContainer = $this->createMock(ContainerInterface::class);
        $mockContainer->method("get")->with($fakeInjectee::DEPENDENCY_ID)->willReturn($givenDependency);
        $sut = new PropertyInjector($mockContainer);

        $sut->inject($fakeInjectee);

        $this->assertInstanceOf(FakeDependency::class, $fakeInjectee->propToInject);
    }

    #[TestDox("Shall not inject protected properties")]
    public function testc()
    {
        $fakeInjectee = new FakeInjecteeWithProtectedProp();
        /**
         * @var ContainerInterface&MockObject
         */
        $mockContainer = $this->createMock(ContainerInterface::class);
        $sut = new PropertyInjector($mockContainer);

        $sut->inject($fakeInjectee);

        $this->assertSame($fakeInjectee::NOT_SET_VALUE, $fakeInjectee->getPropValue());
    }

    #[TestDox("Shall not inject private properties")]
    public function testd()
    {
        $fakeInjectee = new FakeInjecteeWithPrivateProp();
        /**
         * @var ContainerInterface&MockObject
         */
        $mockContainer = $this->createMock(ContainerInterface::class);
        $sut = new PropertyInjector($mockContainer);

        $sut->inject($fakeInjectee);

        $this->assertSame($fakeInjectee::NOT_SET_VALUE, $fakeInjectee->getPropValue());
    }

    #[TestDox("Shall not inject private properties")]
    public function teste()
    {
        $fakeInjectee = new FakeInjecteeWithoutInjectAttribute();
        /**
         * @var ContainerInterface&MockObject
         */
        $mockContainer = $this->createMock(ContainerInterface::class);
        $sut = new PropertyInjector($mockContainer);

        $sut->inject($fakeInjectee);

        $this->assertSame($fakeInjectee::NOT_SET_VALUE, $fakeInjectee->getPropValue());
    }

    #[TestDox("Shall use the class name of object properties when an identifier is not supplied")]
    public function testf()
    {
        $givenDependency = new FakeDependency();
        $fakeInjectee = new FakeInjecteeWithObjectProp();
        /**
         * @var ContainerInterface&MockObject
         */
        $mockContainer = $this->createMock(ContainerInterface::class);
        $mockContainer->method("get")->with($fakeInjectee::DEPENDENCY_ID)->willReturn($givenDependency);
        $sut = new PropertyInjector($mockContainer);

        $sut->inject($fakeInjectee);

        $this->assertInstanceOf(FakeDependency::class, $fakeInjectee->propToInject);
    }

    #[TestDox("Shall set all configured, uninitialized, public properties")]
    public function testg()
    {
        $fakeInjectee = new FakeInjecteeWithMultipleProps();

        $mockContainer = new class () implements ContainerInterface {
            public function has(string $id): bool
            {
                return true;
            }

            public function get(string $id)
            {
                if ($id === FakeInjecteeWithMultipleProps::DEPENDENCY_ID_1) {
                    return "FAKE_DEPENDENCY_1";
                }

                if ($id === FakeInjecteeWithMultipleProps::DEPENDENCY_ID_2) {
                    return "FAKE_DEPENDENCY_2";
                }

                if ($id === FakeInjecteeWithMultipleProps::DEPENDENCY_ID_3) {
                    return "FAKE_DEPENDENCY_3";
                }
            }
        };

        $sut = new PropertyInjector($mockContainer);

        $sut->inject($fakeInjectee);

        $this->assertSame("FAKE_DEPENDENCY_1", $fakeInjectee->propToInject1);
        $this->assertSame("FAKE_DEPENDENCY_2", $fakeInjectee->propToInject2);
        $this->assertSame("FAKE_DEPENDENCY_3", $fakeInjectee->propToInject3);
    }
}
