<?php namespace Tests\Mocks;

use OrFail\Traits\OrFail;

class OverrideMock
{
    use OrFail;

    protected function allowedOrFailMethods()
    {
        return ['loopback'];
    }

    protected function orFailTest($value)
    {
        return $value < 0;
    }

    public function loopback($value)
    {
        return $value;
    }

    public function notAllowed($value)
    {
        return $value;
    }
}
