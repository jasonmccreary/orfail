<?php namespace Tests\Mocks;

use OrFail\Traits\OrFail;

class OverrideMock
{
    use OrFail;

    protected function allowedOrFailMethods() {
        return ['loopback'];
    }

    protected function orFailTest($value) {
        return empty($value);
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
