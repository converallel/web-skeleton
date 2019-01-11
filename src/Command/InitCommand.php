<?php

namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * Init command.
 */
class InitCommand extends Command
{

    /**
     * Hook method for defining this command's option parser.
     *
     * @see https://book.cakephp.org/3.0/en/console-and-shells/commands.html#defining-arguments-and-options
     *
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser)
    {
        $parser = parent::buildOptionParser($parser);

        $parser->addOptions([
            'db-host' => ['short' => 'h', 'default' => 'localhost'],
            'db-user' => ['short' => 'u', 'default' => 'root'],
            'db-password' => ['short' => 'p', 'default' => ''],
        ]);

        $parser->addArguments([
            'db-name' => ['required' => true],
        ]);

        return $parser;
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return null|int The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $dbHost = $args->getArgument('db-host');
        $dbUser = $args->getArgument('db-user');
        $dbPass = $args->getArgument('db-password');
        $dbName = $args->getArgument('db-name');
    }
}
