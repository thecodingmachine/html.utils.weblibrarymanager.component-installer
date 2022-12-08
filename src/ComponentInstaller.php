<?php
namespace Mouf\Html\Utils\WebLibraryManager\ComponentInstaller;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;
use Composer\Repository\InstalledRepositoryInterface;
use Mouf\MoufManager;
use Composer\Config;

/**
 * This Composer installer is in charge of the installation of component files in the Mouf framework.
 *
 * @author David Négrier
 */
class ComponentInstaller extends LibraryInstaller
{
    /**
	 * {@inheritDoc}
	 */
	public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target)
	{
		parent::update($repo, $initial, $target);

		if (!file_exists(__DIR__.'/../../../../mouf/Mouf.php') || !file_exists(__DIR__.'/../../../../config.php')) {
			return;
		}
		require_once(__DIR__.'/../../../../mouf/Mouf.php');

		$moufManager = MoufManager::getMoufManager();
		self::installComponent($target, $this->composer->getConfig(), $moufManager);
	}

	/**
	 * {@inheritDoc}
	 */
	public function uninstall(InstalledRepositoryInterface $repo, PackageInterface $package)
	{
		parent::uninstall($repo, $package);

		if (!file_exists(__DIR__.'/../../../../mouf/Mouf.php') || !file_exists(__DIR__.'/../../../../config.php')) {
			return;
		}
		require_once(__DIR__.'/../../../../mouf/Mouf.php');

		$moufManager = MoufManager::getMoufManager();

		if ($moufManager->has("component.".$package->getName())) {
			$moufManager->removeComponent("component.".$package->getName());
		}
		$moufManager->rewriteMouf();
	}

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return 'component' === $packageType;
    }

    /**
     *
     * @param PackageInterface $package
     * @param Config $config
     * @param MoufManager $moufManager
     */
    public static function installComponent(PackageInterface $package, Config $config, $moufManager) {
    	if (!$moufManager->has('defaultWebLibraryManager')) {
    		return;
    	}

    	$extra = $package->getExtra();

    	if (isset($extra['component']['name'])) {
    		$packageName = $extra['component']['name'];
    	} else {
    		$packageName = explode('/', $package->getName())[1];
    	}

    	if (!$moufManager->has("component.".$packageName)) {

    		$scripts = [];
    		if (isset($extra['component']['scripts'])) {
    			$scripts = array_map(function($script) use ($package) {
    				return "vendor/".$package->getName().'/'.$script;
    			}, $extra['component']['scripts']);
    		}

    		$css = [];
    		if (isset($extra['component']['styles'])) {
    			$css = array_map(function($script) use ($package) {
    				return "vendor/".$package->getName().'/'.$script;
    			}, $extra['component']['styles']);
    		}

    		$deps = [];
    		/*if (isset($extra['component']['deps'])) {
    			$deps = array_map(function($script) {
    				return "component.".$script;
    			}, $extra['component']['css']);
    		}*/

    		WebLibraryInstaller::installLibrary("component.".$packageName, $scripts, $css, $deps, true, $moufManager);
    	}
    	$moufManager->rewriteMouf();
    }
}
