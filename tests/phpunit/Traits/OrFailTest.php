<?php namespace Tests\Traits;

use Tests\Mocks\BasicMock;
use Tests\Mocks\OverrideMock;
use Tests\Mocks\InheritanceMock;
use Tests\Mocks\MagicMock;

class OrFailTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException BadMethodCallException
     */
    public function testThrowsBadMethodCall()
    {
        $mock = new BasicMock();

        $mock->badMethodOrFail();
    }

    /**
     * @dataProvider falseyValuesProvider
     * @expectedException \OrFail\Exceptions\FailingReturnValue
     */
    public function testThrowsFailingReturnValue($value)
    {
        $mock = new BasicMock();

        $mock->loopbackOrFail($value);
    }

    public function testAllowedOrFailMethodsOverride()
    {
        $mock = new OverrideMock();

        $this->assertTrue($mock->loopbackOrFail(true));
    }

    /**
     * @expectedException \OrFail\Exceptions\OrFailMethodNotAllowed
     */
    public function testAllowedOrFailMethodsOverrideThrowsOrFailMethodNotAllowed()
    {
        $mock = new OverrideMock();

        $mock->notAllowedOrFail(null);
    }

    public function testOrFailTestOverride()
    {
        $mock = new OverrideMock();

        $this->assertTrue($mock->loopbackOrFail(true));
    }

    /**
     * @expectedException \OrFail\Exceptions\FailingReturnValue
     */
    public function testOrFailTestOverrideThrowsException()
    {
        $mock = new OverrideMock();

        $mock->loopbackOrFail(-1);
    }

    public function testOrFailCallsInheritedMethod()
    {
        $mock = new InheritanceMock();

        $this->assertTrue($mock->loopbackOrFail(true));
    }

    public function testOrFailCallsInheritedMagicMethod()
    {
        $mock = new MagicMock();

        $this->assertTrue($mock->loopbackOrFail(true));
    }

    public function testOrFailCallsAccessibleMethodNotMagicMethod()
    {
        $mock = new MagicMock();

        $this->assertSame(1, $mock->accessibleMethodOrFail(1));
    }

    public function falseyValuesProvider()
    {
        return [
            [''],
            [0],
            [null],
            [[]],
            [0.0],
            ['0'],
            [false]
        ];
    }
}
