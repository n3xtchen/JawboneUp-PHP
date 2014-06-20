<?php
/**
 * Short description for Console.php
 *
 * @package Console
 * @author n3xtchen <echenwen@gmail.com>
 * @version 0.1
 * @copyright (C) 2014 n3xtchen <echenwen@gmail.com>
 * @license GPL V2
 */
namespace Jawbone;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Jawbone\Up;

class UpCommand extends Command
{

    private $jawbone;

    public function __construct($config)
    {
        parent::__construct();
        $this->jawbone = new Up($config);
    }

    protected function configure()
    {
        $this
        ->setName('jawbone:up')
        ->setDescription('Jawbone Up Command')
        ->addArgument(
            'endpoint',
            InputArgument::OPTIONAL,
            'Enter Jawbone Up\'a Endpoint Name:'
        )
        ->addOption(
            'X',
            null,
            InputOption::VALUE_OPTIONAL,
            'Change The Request Method(GET, POST, DELETE):',
            'GET'
        )
        ->addOption(
            'xid',
            null,
            InputOption::VALUE_OPTIONAL,
            'Change The Request Method(GET, POST, DELETE):',
            null
        )
        ->addOption(
            'data',
            null,
            InputOption::VALUE_OPTIONAL,
            'Change The Request Method(GET, POST, DELETE):',
            null
        )
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $ep     = $input->getArgument('endpoint');
        $method = $input->getOption('X');

        if (in_array($method, ['GET', 'POST', 'PUT', 'DELETE'])) {
            if (in_array($method, ['PUT', 'POST'])) {
                $param  = JSON_DECODE($input->getOption('data'), 1);
            } else {
                $param = $input->getOption('xid');
            }

            $data   = $this->jawbone->$method($ep, $param);
            $output->writeln(JSON_ENCODE($data));
        } else {
            $output->writeln('ERROR!');
        }
    }
}
