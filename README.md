Mnemo
=====

Turns (large) integers into easier to remember Japanese sounding words and vice versa.

This is a port of the Ruby module [rufus-mnemo][rufus-mnemo].

Requirements
------------

This library uses [PSR-0][PSR-0] compliant namespaces, thus requiring PHP 5.3 or later. 

There are no further dependencies.

Installation
------------

This library is available as a [Composer][Composer] package. Add the following to your `composer.json` file:

    {
        "require": {
            "blendwerk/mnemo": "master"
        }
    }

Alternatively clone this repo and use a [PSR-0][PSR-0] compliant autoloader or manually require `Mnemo.php`.

Usage
-----

    <?php
    
    use Blendwerk\Mnemo\Mnemo;
    
    Mnemo::fromInteger(125704);
      # => "karasu"
    
    Mnemo::toInteger('karasu');
      # => 125704
      
    Mnemo::fromInteger(-173866);
      # => winamote (Negative integers are prefixed with the "wi" syllable.)
    
    Mnemo::isMnemoWord('kazuma');
      # => true
      
    Mnemo::isMnemoWord('richard');
      # => false
      
    ?>

Project Home
------------

This project can be found on https://github.com/aleksblendwerk/Mnemo.

Motivation
----------

I mainly started this project as an exercise in current open source and PHP standards:

* [PSR-0][PSR-0], [PSR-1][PSR-1] and [PSR-2][PSR-2] coding standards
* Packaging using [Composer][Composer]
* Distribution via [Packagist][Packagist]
* Testing with [PHPUnit][PHPUnit]
* Inline code documentation according to [phpDocumentor][phpDocumentor]
* Version control on [GitHub][GitHub]

While none of these are entirely new to me, I felt the urge to go through the whole process once and have a proper project applying best practices out there, hopefully paving the way for many more to come.

Credits
-------

* John Mettraux, the author of the original Ruby module [rufus-mnemo][rufus-mnemo]

License
-------

Mnemo is licensed under the MIT license.

[Composer]: http://getcomposer.org/
[GitHub]: https://github.com/
[PSR-0]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
[PSR-1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[PSR-2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[Packagist]: http://packagist.org/
[phpDocumentor]: http://www.phpdoc.org/
[PHPUnit]: https://github.com/sebastianbergmann/phpunit/
[rufus-mnemo]: http://rufus.rubyforge.org/rufus-mnemo/
