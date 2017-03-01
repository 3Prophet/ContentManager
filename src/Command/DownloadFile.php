<?php

namespace Packimpex\ContentManager\Command;

use Packimpex\ContentManager\Configuration\ConfigurationMapper;
use Packimpex\ContentManager\FileManager;

class DownloadFile implements CommandInterface
{
	private $app_factory = null;
	
	/**
	 * @param Packimpex\ContentManager\Configuration\ConfigurationFactoryInterface $config_factory
	 */
	private function setAppFactory($app_factory)
	{
		$this->app_factory = $app_factory;
	}
	/**
	 * Controller method that handles content download
	 *
	 * @return void
	 */
	public function execute()
	{
		$this->setAppFactory(ConfigurationMapper::getConfigurationFactory($_GET["context"]));
		// setting up request registry which will be used by domain logic
		$this->app_factory->getRequestRegistry()->setUserId((new Users())->getUserId());
		$this->app_factory->getRequestRegistry()->setModuleItemId($_GET["bkg_id"]);
		$this->app_factory->getRequestRegistry()->setContentItemId($_GET["file_id"]);
		
		// initializing filemanager and delegating download to it (domain logic)
		$filemanager = new FileManager($this->app_factory);
		$filemanager->handleDownload();
	}
}
