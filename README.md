# xu

[![Build Status](https://travis-ci.org/wp-xu/xu.svg?branch=master)](https://travis-ci.org/wp-xu/xu) [![codecov.io](http://codecov.io/github/wp-xu/xu/coverage.svg?branch=master)](http://codecov.io/github/wp-xu/xu?branch=master)
[![License](https://img.shields.io/packagist/l/wp-xu/xu.svg)](https://packagist.org/packages/wp-xu/xu)

> Requires PHP 5.4

Collection of useful WordPress and PHP functions

## Install

```
$ composer require wp-xu/xu
```

## Documentation

[API reference docs](https://wp-xu.github.io/docs/)

### Components

xu comes with a couple of [components](https://github.com/wp-xu/xu/tree/master/src/components).
Every component is a class that you can use the components public methods.

Example of [personnummer](https://github.com/wp-xu/xu/blob/master/src/components/class-personnummer.php)
component that is a wrapper around [frozzare/php-personnummer](https://github.com/frozzare/php-personnummer)
that validates Swedish personal identify numbers.

```php
if ( xu( 'personnummer' )->valid( '19130401+2931' ) ) {
  echo 'Valid!';
}
```

## License

MIT © [Fredrik Forsmo](https://github.com/frozzare)
