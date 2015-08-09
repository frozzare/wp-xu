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

> WIP

You can call xu functions with `xu_` prefix or `xu::` for static methods.

Example:

```php
xu_is_post_type( 123, 'post' );

// or

xu::is_post_type( 123, 'post' );
```

## License

MIT © [Fredrik Forsmo](https://github.com/frozzare)
