<?php
/**
 * Short description for UpCommand.php
 *
 * @package UpCommand
 * @author n3xtchen <echenwen@gmail.com>
 * @version 0.1
 * @copyright (C) 2014 n3xtchen <echenwen@gmail.com>
 * @license GPL V2
 */
namespace Jawbone\Tests;

use Symfony\Component\Yaml\Parser;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\NullOutput;

use Jawbone\UpCommand;

class UpCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testSetApp()
    {
        $path = __DIR__.'/Fixtures';
        $yml  = new Parser();
        $config = $yml->parse(file_get_contents($path.'/JawboneOpts.yml'));

        $app = new Application();
        $up_command = new UpCommand($config);
        $up_command->setApplication($app);

        $this->assertEquals($app, $up_command->getApplication(), '->setApplication() sets the current application');
    }
}
