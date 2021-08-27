# phpbb-text-shortener library

### About

phpbb-text-shortener is a PHP library for shortening post text in phpBB 3.3.x to a specified length.

### Requirements

PHP 7.1.3 or newer is required for this library to work.

### Installation

It is recommend to install the library using composer.
Just add the following snippet to your composer.json:
```
  "require": {
    "marc1706/phpbb-text-shortener": "~0.2"
  },
```

### Usage

Create an instance of text shortener:
```injectablephp
$shortener = new \Marc1706\TextShortener\Shortener();
```

Grab the database representation of a post from the database and pass it to the shortener (e.g. to a length of 200 characters):
```injectablephp
$shortener->setText($postText)
	->shortenText(200);
```

### Automated Tests

The library is being tested using unit tests to prevent possible issues.

[![Build Status](https://github.com/marc1706/phpbb-text-shortener/actions/workflows/main.yml/badge.svg)](https://github.com/marc1706/phpbb-text-shortener/actions/workflows/main.yml)

### License

[The MIT License (MIT)](http://opensource.org/licenses/MIT)
