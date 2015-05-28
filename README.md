# PHP OrFail Trait

OrFail is a simple [trait](http://php.net/manual/en/language.oop5.traits.php) which makes it easier to practice exceptional programming and write cleaner code.

Through [magic](http://php.net/manual/en/language.oop5.magic.php), OrFail allows you to append `OrFail` to any method name and force it to *fail* (throw an exception) if that method returned `null`.

Code without OrFail:

    public function someMethod() {
        $value = $this->getValue();
        
        if ($value === null) {
            // failure code
        }
    
        return $value;
    }

The same code using OrFail:

    public function someMethod() {
        return $this->getValueOrFail();
    }


# Configuration

OrFail has two methods you may optionally override: `orFailTest()` and `allowedOrFailMethods()`.

    bool orFailTest ( mixed $value )

By default `orFailTest()` simply tests if `$value` is strictly equal to `null`. You can override this method to perform your own failure test.
  
    array allowedOrFailMethods ( void )
    
By default `orFailMethods()` allows returns an empty array which all methods. You can restrict which methods allow being called with `OrFail` appended by overriding this method and returning an array with the allowed method names. 