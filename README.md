# Page Fetcher 

[![Build Status](https://travis-ci.org/themichaelhall/page-fetcher.svg?branch=master)](https://travis-ci.org/themichaelhall/page-fetcher)
[![codecov.io](https://codecov.io/gh/themichaelhall/page-fetcher/coverage.svg?branch=master)](https://codecov.io/gh/themichaelhall/page-fetcher?branch=master)
[![Maintainability](https://api.codeclimate.com/v1/badges/ebad8770a997ff3dc0d6/maintainability)](https://codeclimate.com/github/themichaelhall/page-fetcher/maintainability)
[![StyleCI](https://styleci.io/repos/108880804/shield?style=flat)](https://styleci.io/repos/108880804)
[![License](https://poser.pugx.org/michaelhall/page-fetcher/license)](https://packagist.org/packages/michaelhall/page-fetcher)
[![Latest Stable Version](https://poser.pugx.org/michaelhall/page-fetcher/v/stable)](https://packagist.org/packages/michaelhall/page-fetcher)
[![Total Downloads](https://poser.pugx.org/michaelhall/page-fetcher/downloads)](https://packagist.org/packages/michaelhall/page-fetcher)

A simple web client.

## Requirements

- PHP >= 7.1

## Install with Composer

``` bash
$ composer require michaelhall/page-fetcher
```

## Basic usage

### Fetch a page

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

$pageFetcher = new \MichaelHall\PageFetcher\PageFetcher();

$url = \DataTypes\Url::parse('https://example.com/');
$request = new \MichaelHall\PageFetcher\PageFetcherRequest($url);
$response = $pageFetcher->fetch($request);

// Prints "success" if request was successful, "fail" otherwise.
echo $response->isSuccessful() ? 'success' : 'fail';

// Prints the response content.
echo $response->getContent();

// Prints the http code, e.g. 200.
echo $response->getHttpCode();

// Prints the headers.
foreach ($response->getHeaders() as $header) {
    echo $header;
}
```

### Customize the request

```php
// Set the method.
$request = new \MichaelHall\PageFetcher\PageFetcherRequest($url, 'POST');

// Set a POST field.
$request->setPostField('Foo', 'Bar');

// Set a file.
$request->setFile('Baz', \DataTypes\FilePath::parse('/path/to/file'));

// Add a header.
$request->addHeader('Content-type: application/json');

// Set raw content.
$request->setRawContent('{"Foo": "Bar"}');
```

### Use the fake page fetcher for application testing

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

$pageFetcher = new \MichaelHall\PageFetcher\FakePageFetcher();
$pageFetcher->setResponseHandler(function ($request) {
    return new \MichaelHall\PageFetcher\PageFetcherResponse(200, 'Request url is ' . $request->getUrl());
});

$url = \DataTypes\Url::parse('https://example.com/');
$request = new \MichaelHall\PageFetcher\PageFetcherRequest($url);
$response = $pageFetcher->fetch($request);

// Prints "Request url is https://example.com/".
echo $response->getContent();
```

Both the `PageFetcher` and `FakePageFetcher` classes implements the `\MichaelHall\PageFetcher\Interfaces\PageFetcherInterface` interface, making it possible to use for dependency injection in the application.

## License

MIT
