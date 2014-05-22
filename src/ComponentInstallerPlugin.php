<?php
namespace Mouf\Html\Utils\WebLibraryManager\ComponentInstaller;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

/**
 * This Composer plugin is in charge of the installation of component files.
 * 
 * @author David Négrier
 */
class ComponentInstallerPlugin implements PluginInterface {
	
	public function activate(Composer $composer, IOInterface $io)
	{
		$installer = new ComponentPlugin($io, $composer);
		$composer->getInstallationManager()->addInstaller($installer);
	}
}
