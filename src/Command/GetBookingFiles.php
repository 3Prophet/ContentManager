<?php

namespace Packimpex\ContentManager\Command;

use Packimpex\ContentManager\Configuration\ConfigurationMapper;
use Packimpex\ContentManager\FileManager;

class GetBookingFiles implements CommandInterface
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
		$this->setAppFactory(ConfigurationMapper::getConfigurationFactory($context));
		
		$this->app_factory->getRequestRegistry()->setUserId((new Users())->getUserId());
		$this->app_factory->getRequestRegistry()->setModuleItemId($bkg_id);
		return (new FileManager($this->app_factory))->getManagedContent();
	}
}