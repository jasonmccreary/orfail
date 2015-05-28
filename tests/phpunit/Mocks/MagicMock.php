<?php namespace Tests\Mocks;

use OrFail\Traits\OrFail;

class MagicBase
{
    public function __call($method, array $parameters)
    {
        return true;
    }
}

// @codingStandardsIgnoreStart
class MagicMock extends MagicBase
{
    use OrFail;
}
// @codingStandardsIgnoreEnd
