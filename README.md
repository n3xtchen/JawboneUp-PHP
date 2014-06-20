JawboneUp-PHP
=============

Jawbone UP API PHP Library

API Version:v.1.1(Official)

If you would like to contribute to this project in any way, including to update it to support API v1.1, please send me a pull request!

Official UP API: [jawbone.com/up/developer](jawbone.com/up/developer)

## REQUIREMENT

PHP VERSION: `>=5.4`

## Installation

1. Create a new file called `composer.json` and paste the following into it:

	```	
	{
    	"require": {
       		"n3xtchen/jawbone": "0.1.0.x-dev"
   		}
	} 
	```
	
	If you already have a `composer.json` file, just add this line to it. 
	
	You can research the component names and versions at [packagist.org](packagist.org).
	
2. [Install composer](http://getcomposer.org/download/) if you don't already have it present on your system:

3. Download the vendor libraries and generate the vendor/autoload.php file: 
	
	```	
	$ php composer.phar install 
	```
	

## Documentation

An access_token attribute is required in the options object! See below for an example of how this could be done. This library does not assist in getting an access_token through OAuth, but once you get the token, it will apparently last for a year.

A app_secret attribute is required if you would like to use `refreshToken` to get new refresh tokens. It is not required otherwise.

```
<?php
Use Jawbone\Up;

//Jawbone Option
$config = [
  'client_id'     => '123',
  'client_secret' => 'abc',
  'access_token'  => 'xyz'
];

$up = new Up($config);
```

### Get

```
// get All events
$up->get($event_name)               // GET /nudge/api/v.1.1/users/@me/{$event_name}

// get a specific event
$up->get($event_name, $xid)        // GET /nudge/api/v.1.1/{$event_name}/{$xid}
```

### POST

```
$up->post($event_name, $data);   // POST /nudge/api/v.1.1/users/@me/{$event_name} $data
```

### DELETE

```
// delete a specific event
$up->delete($event_name, $xid);  // DELETE /nudge/api/v.1.1/{$event_name}/{$xid}
```

## Console


```
#!/usr/bin/env php
<?php
// DemoConsole.php

include(__DIR__.'/path/to/vendor/autoload.php');

use Symfony\Component\Console\Application;

use Jawbone\UpCommand;

//Jawbone Option
$config = [
  'client_id'     => '123',
  'client_secret' => 'abc',
  'access_token'  => 'xyz'
];

$application = new Application();
$application->add(new UpCommand($config));
$application->run();
```

### Usages

```
$ php path/to/DemoConsole.php jawbone:up {$event_name} 
	--X='POST|GET|PUT' 
	--data='{"key":"value",...}' 
```
	
## Tests

You can run the unit tests with the following command:

	```
	$ cd path/to/Jawbone/
	$ mv phpunit.xml.dist phpunit.xml
	$ mv Tests/Fixtures/JawboneOpts.yml.test Tests/Fixtures/JawboneOpts.yml
	# Fill Your relative app info in the Tests/Fixtures/JawboneOpts.yml
	$ composer.phar install
	$ phpunit
	```

