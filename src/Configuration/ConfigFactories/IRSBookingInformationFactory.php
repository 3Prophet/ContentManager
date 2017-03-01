<?php

namespace Packimpex\ContentManager\Configuration\ConfigFactories;

use Packimpex\ContentManager\Configuration\ConfigFactoryInterface; 

use Packimpex\ContentManager\Configuration\StrategyFactory;
use Packimpex\ContentManager\Configuration\MapperFactory;
use Packimpex\ContentManager\Configuration\DatabaseTableMapper;

use Packimpex\ContentManager\Configuration\IRS\DatabaseTableMap;
use Packimpex\ContentManager\Configuration\IRS\DSN;

use Packimpex\ContentManager\Configuration\IRS\Bookings\ContentLocationMap;
use Packimpex\ContentManager\Configuration\IRS\Bookings\MapperMap;
use Packimpex\ContentManager\Configuration\IRS\Bookings\StrategyMap;
use Packimpex\ContentManager\Configuration\IRS\Bookings\GroupPermissionMap;

use Packimpex\ContentManager\Domain\FileTransferManager;
use Packimpex\ContentManager\Registries\RequestRegistry;
use Packimpex\ContentManager\Database\PDOSingleton;


class IRSBookingInformationFactory implements ConfigFactoryInterface
{
	public function getStrategyFactory()
	{
		return StrategyFactory::instance(StrategyMap::$strategy_map);
	}
	
	public function getMapperFactory()
	{
		return MapperFactory::instance(
								PDOSingleton::construct(DSN::$dsn),
								MapperMap::$mapper_map,
								new DatabaseTableMapper(DatabaseTableMap::$database_table_map));
	}
	
	public function getFileTransferManager()
	{
		return new FileTransferManager(ContentLocationMap::$content_location_map["content_location"]);
	}
	
	public function getRequestRegistry()
	{
		RequestRegistry::instance()->setJobId(1);
		return RequestRegistry::instance();
	}
	
	public function getGroupPermissionMap()
	{
		return GroupPermissionMap::$group_permission_map;
	}
}