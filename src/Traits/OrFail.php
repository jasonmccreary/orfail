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
    public function __call($method, array $parameters)
    {
        $method = $this->normalizeMethodName($method);

        if (!$this->isMethodAllowed($method)) {
            throw new OrFailMethodNotAllowed($method . '() can not be called using OrFail');
        }

        if (!method_exists($this, $method) && !is_callable(['parent', '__call'])) {
            throw new \BadMethodCallException($method . '() does not exist');
        }

        if (is_callable(['parent', '__call'])) {
            $return = parent::__call($method, $parameters);
        } else {
            $return = call_user_func_array([$this, $method], $parameters);
        }

        if ($this->orFailTest($return)) {
            throw new FailingReturnValue($method . '() returned a failing value');
        }

        return $return;
    }

    protected function orFailTest($value)
    {
        return is_null($value);
    }

    protected function allowedOrFailMethods()
    {
        return [];
    }

    private function normalizeMethodName($method)
    {
        if (substr($method, -6) == 'OrFail') {
            return substr($method, 0, -6);
        }

        return $method;
    }

    private function isMethodAllowed($method)
    {
        $allowed_methods = $this->allowedOrFailMethods();
        if (empty($allowed_methods)) {
            return true;
        }

        return in_array($method, $allowed_methods);
    }
}
