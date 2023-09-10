<?php

namespace WebTheory\Pathagist\Console;

use Symfony\Component\Console\Input\InputArgument;
use WebTheory\Pathagist\Config\Config;

class UnloadCommand extends AbstractCommand
{
    protected $config;

    public function __construct(Config $config)
    {
        parent::__construct();

        $this->config = $config;
    }

    protected function configure()
    {
        $this
            ->setName('unload')
            ->setDescription('Unload a package path from being managed with Pathagist')
            ->addArgument(
                'path',
                InputArgument::IS_ARRAY | InputArgument::REQUIRED,
                'The path(s) where the package files are located'
            );
    }

    protected function fire()
    {
        foreach ($this->input->getArgument('path') as $path) {
            $this->config->removePath($path);

            $this->io->success("Packages matching the path $path will no longer be loaded by Composer.");
        }
    }
}
