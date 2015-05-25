<?php namespace Tests\Mocks;

use OrFail\Traits\OrFail;

class InheritanceBase
{
    public function loopback($value)
    {
        return $value;
    }
}

class InheritanceMock extends InheritanceBase
{
    use OrFail;
}
