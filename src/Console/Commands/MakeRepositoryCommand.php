<?php

namespace Duxingyu\Repository\Console\Commands;

use Duxingyu\Repository\Console\Commands\Creators\RepositoryCreator;
use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class MakeRepositoryCommand
 *
 * @package Bosnadev\Repositories\Console\Commands
 */
class MakeRepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:repository';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    /**
     * @var RepositoryCreator
     */
    protected $creator;

    /**
     * @var Composer
     */
    protected $composer;

    /**
     * @param RepositoryCreator $creator
     */
    public function __construct(RepositoryCreator $creator)
    {
        parent::__construct();

        // Set the creator.
        $this->creator = $creator;

        // Set composer.
        $this->composer = app()['composer'];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get the arguments.
        $arguments = $this->argument();
        // Get the options.
        $options = $this->option();
        // Write repository.
        $this->writeRepository($arguments, $options);

        // Dump autoload.
        $this->composer->dumpAutoloads();
    }

    /**
     * @param $arguments
     * @param $options
     */
    protected function writeRepository($arguments, $options)
    {
        // Set repository.
        $repository = $arguments['repository'];

        // Set model.
        $model = str_replace('/', '\\', $options['model'], $count);

        // Create the repository.
        if ($this->creator->create($repository, $model)) {
            // Information message.
            $this->info("Successfully created the repository class");
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['repository', InputArgument::REQUIRED, 'The repository name.']
        ];
    }

    /**
     * Get the console command options.
     * --model=User
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', '-m', InputOption::VALUE_OPTIONAL, 'The model name.', null],
        ];
    }
}
