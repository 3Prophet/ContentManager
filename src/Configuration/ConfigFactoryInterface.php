<?php

namespace Packimpex\ContentManager\Configuration;

/**
 * A set of factory methods which allow initialization of the application
 * per page per job. 
 */
interface ConfigFactoryInterface
{
	public function getStrategyFactory();
	
	public function getMapperFactory();
	
	public function getFileTransferManager();
	
	public function getRequestRegistry();
	
	public function getGroupPermissionMap();
}