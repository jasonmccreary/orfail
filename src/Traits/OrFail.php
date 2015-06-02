<?php namespace OrFail\Traits;

use OrFail\Exceptions\FailingReturnValue;
use OrFail\Exceptions\OrFailMethodNotAllowed;

trait OrFail
{
    /**
     * Allows appending OrFail to existing, allowed methods and tests the return value.
     *
     * @param $method
     * @param array $parameters
     * @return mixed
     *
     * @throws BadMethodCallException
     * @throws OrException
     * @throws OrFailMethodNotAllowed
     */
    public function __call($method, $parameters)
    {
        $method = $this->normalizeMethod($method);

        if (!$this->isMethodAllowed($method)) {
            throw new OrFailMethodNotAllowed($method . '() can not be called using OrFail');
        }

        if (method_exists($this, $method)) {
            $return = call_user_func_array([$this, $method], $parameters);
        } elseif (is_callable(['parent', '__call'])) {
            $return = parent::__call($method, $parameters);
        } else {
            throw new \BadMethodCallException($method . '() does not exist');
        }

        if ($this->orFailTest($return)) {
            throw new FailingReturnValue($method . '() returned a failing value');
        }

        return $return;
    }

    /**
     * Test if $value is failing.
     *
     * @param $value
     *
     * @return bool
     */
    protected function orFailTest($value)
    {
        return empty($value);
    }

    /**
     * Array of method names allowed to be
     * called with OrFail suffix. Allows all
     * method names by default (empty array).
     *
     * @return array
     */
    protected function allowedOrFailMethods()
    {
        return [];
    }

    /**
     * Remove OrFail from $method
     *
     * @param $method
     *
     * @return string
     */
    private function normalizeMethod($method)
    {
        if (substr($method, -6) == 'OrFail') {
            return substr($method, 0, -6);
        }

        return $method;
    }

    /**
     * Test if $method is allowed to be called
     * with OrFail suffix.
     *
     * @param $method
     *
     * @return bool
     */
    private function isMethodAllowed($method)
    {
        $allowed_methods = $this->allowedOrFailMethods();
        if (empty($allowed_methods)) {
            return true;
        }

        return in_array($method, $allowed_methods);
    }
}
