<?php

namespace WebTheory\Pathagist\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Package\Link;
use Composer\Repository\PathRepository;
use WebTheory\Pathagist\Config\Config;

class Registrar
{
    /**
     * @var Composer
     */
    protected $composer;

    /**
     * @var IOInterface
     */
    protected $io;

    /**
     * @var Config
     */
    protected $config;

    public function __construct(Composer $composer, IOInterface $io, Config $config)
    {
        $this->composer = $composer;
        $this->io = $io;
        $this->config = $config;
    }

    /**
     * Register all managed paths with Composer.
     *
     * This function configures Composer to treat all Pathagist-managed paths as
     * local path repositories, so that packages therein will be symlinked
     * directly.
     */
    public function register()
    {
        $repoManager = $this->composer->getRepositoryManager();
        $composerConfig = $this->composer->getConfig();

        foreach ($this->getManagedPaths() as $path) {
            $this->io->write("[Pathagist] Loading path $path");
            $repoConfig = $this->getRepoConfig($path);

            // Composer v2 always exposes the internal loop, so keep reusing it
            // that is a fixed requirement since Composer >= 2.3
            if (method_exists($this->composer, 'getLoop')) {
                $repoManager->prependRepository(new PathRepository(
                    $repoConfig,
                    $this->io,
                    $composerConfig,
                    $this->composer->getLoop()->getHttpDownloader(),
                    $this->composer->getEventDispatcher(),
                    $this->composer->getLoop()->getProcessExecutor()
                ));
            } else {
                $repoManager->prependRepository(new PathRepository(
                    $repoConfig,
                    $this->io,
                    $composerConfig
                ));
            }
        }
    }

    /**
     * Get the list of paths that are being managed by Pathagist.
     *
     * @return array
     */
    protected function getManagedPaths()
    {
        return $this->config->getPaths();
    }

    protected function getRepoConfig($path): array
    {
        return [
            'url' => $path,
            'options' => [
                'versions' => $this->getVersions($path),
            ],
        ];
    }

    protected function getVersions($path): array
    {
        $package = $this->composer->getPackage();
        $requires = $package->getRequires();
        $devRequires = $package->getDevRequires();
        $resolver = fn (Link $link) => $link
            ->getConstraint()
            ->getLowerBound()
            ->getVersion();

        return array_map($resolver, $requires + $devRequires);
    }
}
