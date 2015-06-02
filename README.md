# PHP OrFail Trait
OrFail is a simple [trait](http://php.net/manual/en/language.oop5.traits.php) which makes it easier to practice exceptional programming and write cleaner code.

Through [magic](http://php.net/manual/en/language.oop5.magic.php), OrFail allows you to append `OrFail` to any method name and force it to *fail* (throw an exception) if that method returns a [falsey value](http://php.net/manual/en/language.types.boolean.php).

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

## Requirements
- PHP >= 5.4.0

## Installation
The recommended way to install OrFail is with [Composer](https://getcomposer.org):

    composer require "jasonmccreary/orfail"

Alternatively you can download the `src` directory of this project and include it in your project.

## Usage
Once OrFail is included in your project you may add it to any class by simply using the trait.

For example:

    class Example {
        use OrFail\Traits\OrFail;
        
        public function someMethod() {
            // code
        }
    }

Now you can call any method with *OrFail* appended. If the method returns a falsey value a `FailingReturnValue` exception will be thrown.

## Configuration
OrFail has two methods you may optionally override: `orFailTest()` and `allowedOrFailMethods()`.

    bool orFailTest ( mixed $value )

By default `orFailTest()` simply tests if `$value` is *falsey*. You can override this method to perform your own failure test.
  
    array allowedOrFailMethods ( void )
    
By default `orFailMethods()` returns an empty array which allows all methods. You can restrict which methods allow being called with `OrFail` appended by overriding this method and returning an array of the allowed method names.

## Troubleshooting
Since OrFail uses magic methods, it is easy to create an infinite call loop if you are not careful. This most commonly results in PHP exhausting its memory or a *Segmentation Fault 11*.

If you wish to use the OrFail trait in a class that implements `__call()` you will need to resolve the conflict manually.

For example:

    class YourClass {
        use OrFail\Traits\OrFail {
            OrFail::__call as __callOrFail;
        }
        
        public function __call($name, $parameters) {
            // your code
            $this->__callOrFail($name, $parameters);
            // your code
        }
    }

**Note:** this is only an example of how to resolve the conflict. How you call OrFail will depend on your code.

## Contributing
OrFail is a new package and needs more integration testing with other packages and codebases using `__call()`. Please report any problems by creating an [Issue](https://github.com/jasonmccreary/orfail/issues).

If you plan to submit a [Pull Request](https://github.com/jasonmccreary/orfail/pulls), please ensure you follow the [PSR-2 Style Guide](http://www.php-fig.org/psr/psr-2/).
 
Thanks.