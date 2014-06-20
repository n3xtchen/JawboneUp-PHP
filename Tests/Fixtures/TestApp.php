#!/usr/bin/env php
<?php

include(__DIR__.'/../../vendor/autoload.php');
    
use Symfony\Component\Console\Application;
use Symfony\Component\Yaml\Parser;

use Jawbone\UpCommand;

$yml  = new Parser();
$config = $yml->parse(file_get_contents(__DIR__.'/JawboneOpts.yml'));

$application = new Application();
$application->add(new UpCommand($config));
$application->run();
