# xu framework

[![Build Status](https://travis-ci.org/wp-xu/framework.svg?branch=master)](https://travis-ci.org/wp-xu/framework) [![codecov.io](http://codecov.io/github/wp-xu/framework/coverage.svg?branch=master)](http://codecov.io/github/wp-xu/framework?branch=master)
[![License](https://img.shields.io/packagist/l/wp-xu/framework.svg)](https://packagist.org/packages/wp-xu/framework)

> Requires PHP 5.5

xu framework. You'll probably want to use [wp-xu/xu](https://github.com/wp-xu/xu) plugin instead.

## Install

```
$ composer require wp-xu/framework
```

## Documentation

[API reference docs](https://wp-xu.github.io/docs/)

### Components

Go to [wp-xu/components](https://github.com/wp-xu/components) repo.

## Models

With xu you can create models that you load from your theme (with `xu_get_model`) or any where, just use the class.

```php
<?php

use Xu\Model\Model;

class Post extends Model {
  
  /**
   * Get model attributes.
   *
   * @return array
   */
  public function get_attributes() {
     return [
       'title' => $this->post->post_title
     ];
  }
}
```

In your template file:

```php
$model = xu_get_model( 'post' );

echo $post->title;
```

The model class implements a lot of methods like `to_array` and `to_json` to convert the model to a array or JSON string.

## Models Collection

A collection is a collection of one or more models. By reading the [api reference docs](https://wp-xu.github.io/docs/) you can find out which methods a collection has, `first`, `last`, `filter`, `map`, `reject` and `where` is some of the methods that exists.

A collection can be created in different ways:

```php
use Xu\Model\Collection;

$collection = new Collection( [$model1, $model2] );
$collcetion = Post::collection( [$model1, $model2] );

class List extends Model {
  
  /**
   * Get all posts that exists on `post` post type.
   *
   * @return \Xu\Model\Collection
   */
  public function posts() {
    return static::collection( get_posts( 'post_type=post' ) );
  }
}

$collection = ( new List )->posts();
```

## License

MIT © [Fredrik Forsmo](https://github.com/frozzare)
