<?php

namespace WebTheory\Pathagist\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use WebTheory\Pathagist\Config\Config;

class Factory
{
    /**
     * @var Composer
     */
    protected $composer;

    /**
     * @var IOInterface
     */
    protected $io;

    public function __construct(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }

    public function create(): Registrar
    {
        return new Registrar($this->composer, $this->io, $this->getConfig());
    }

    protected function getConfig(): Config
    {
        return Config::make();
    }
}
