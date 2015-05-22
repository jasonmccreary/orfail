<?php namespace Tests\Traits;

use Tests\Mocks\BasicMock;
use Tests\Mocks\OverrideMock;
use Tests\Mocks\InheritanceMock;

class OrFailTest extends \PHPUnit_Framework_TestCase
{
    public function testOrFailTest()
    {
        $mock = $this->getMockForTrait('OrFail\Traits\OrFail');

        $this->assertTrue($mock->orFailTest(null));
        $this->assertFalse($mock->orFailTest(0));
        $this->assertFalse($mock->orFailTest('value'));
    }

    public function testAllowedOrFailMethods()
    {
        $mock = $this->getMockForTrait('OrFail\Traits\OrFail');

        $this->assertCount(0, $mock->allowedOrFailMethods());
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function testThrowsBadMethodCall()
    {
        $mock = new BasicMock();

        $mock->badMethodOrFail();
    }

    /**
     * @expectedException \OrFail\Exceptions\FailingReturnValue
     */
    public function testThrowsFailingReturnValue()
    {
        $mock = new BasicMock();

        $mock->loopbackOrFail(null);
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

    /**
     *
     */
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

        $mock->loopbackOrFail(false);
    }

    public function testOrFailCallsInheritedMethod() {
        $mock = new InheritanceMock();

        $this->assertTrue($mock->loopbackOrFail(true));
    }
}
