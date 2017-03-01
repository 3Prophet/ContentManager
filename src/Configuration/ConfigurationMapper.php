<?php

namespace Packimpex\ContentManager\Configuration;

use Packimpex\ContentManager\Configuration\ConfigFactoriesMaps\ConfigurationMap;

class ConfigurationMapper
{										
	public static function getConfigurationFactory($key)
	{
		$configuration_map = ConfigurationMap::$configuration_map;
		
		if (!array_key_exists($key, $configuration_map)) {
			throw new \Exception("The key '$key' does not exist in the configuration map!");
		}
		
		$class = $configuration_map[$key];
		return new $class();
	}
}