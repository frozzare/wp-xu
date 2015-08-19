# xu components

[![Build Status](https://travis-ci.org/wp-xu/components.svg?branch=master)](https://travis-ci.org/wp-xu/components) [![codecov.io](http://codecov.io/github/wp-xu/components/coverage.svg?branch=master)](http://codecov.io/github/wp-xu/components?branch=master)
[![License](https://img.shields.io/packagist/l/wp-xu/components.svg)](https://packagist.org/packages/wp-xu/components)

> Requires PHP 5.4

Collection of xu components.

## Install

```
$ composer require wp-xu/components
```

## Documentation

[API reference docs](https://wp-xu.github.io/docs/components)

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
