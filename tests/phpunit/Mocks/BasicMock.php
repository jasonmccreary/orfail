<?php namespace Tests\Mocks;

use OrFail\Traits\OrFail;

class BasicMock
{
    use OrFail;

    public function loopback($value)
    {
        return $value;
    }
}
