<?php

namespace Packimpex\ContentManager\Command;

use Packimpex\ContentManager\Configuration\ConfigurationMapper;
use Packimpex\ContentManager\FileManager;

class DeleteFile implements CommandInterface
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
	 * Controller method that handles content deletion
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
		
		
		// initializing filemanager and delegating delete to it (domain logic)
		$filemanager = new FileManager($this->app_factory);
		$filemanager->handleDelete();
		
		// redirecting to the view
		redirect("viewbooking", false, "&bkg_id=" . $_GET["bkg_id"]);
	}
}