<?php
namespace Mouf\Html\Utils\WebLibraryManager\ComponentInstaller;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;
use Composer\Repository\InstalledRepositoryInterface;

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
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
	{
		parent::install($repo, $package);
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function uninstall(InstalledRepositoryInterface $repo, PackageInterface $package)
	{
		parent::uninstall($repo, $package);
	}

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return 'component' === $packageType;
    }
}
