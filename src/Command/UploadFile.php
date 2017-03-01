<?php

namespace Packimpex\ContentManager\Command;

use Packimpex\ContentManager\Configuration\ConfigurationMapper;
use Packimpex\ContentManager\FileManager;

class UploadFile implements CommandInterface
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
	 * Controller method that handles content upload
	 *
	 * @return void
	 */
	public function execute()
	{
		$this->setAppFactory(ConfigurationMapper::getConfigurationFactory($_POST["context"]));
		
		$this->app_factory->getRequestRegistry()->setUserId((new Users())->getUserId());
		$this->app_factory->getRequestRegistry()->setModuleItemId($_POST["bkg_id"]);
		$this->app_factory->getRequestRegistry()->setFileToUploadArray($_FILES["fileToUpload"]);
		
		// checks whether the content is to be shared with the transferee
		if ($_POST["shareWithTransferee"] == "yes") {
			$this->app_factory->getRequestRegistry()->setShareWithTransferee(true);
			$this->app_factory->getRequestRegistry()->setTypes(array("view"));
		}
		
		// initializing filemanager and delegating upload to it (domain logic)
		$filemanager = new FileManager($this->app_factory);
		$filemanager->handleUpload();
		
		// redirecting to the view
		redirect("viewbooking", false, "&bkg_id=" . $_POST["bkg_id"]);
	}
}