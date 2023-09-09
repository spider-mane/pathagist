<?php

namespace WebTheory\Pathagist;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\ScriptEvents;
use WebTheory\Pathagist\Composer\Factory;

class Plugin implements PluginInterface, EventSubscriberInterface
{
    /**
     * @var Factory
     */
    protected $factory;

    public function activate(Composer $composer, IOInterface $io)
    {
        $this->factory = new Factory($composer, $io);
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
        //
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
        //
    }

    public function registerPackages()
    {
        $this->factory->create()->register();
    }

    public static function getSubscribedEvents()
    {
        return [
            ScriptEvents::PRE_INSTALL_CMD => 'registerPackages',
            ScriptEvents::PRE_UPDATE_CMD => 'registerPackages',
        ];
    }
}
