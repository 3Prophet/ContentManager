<?php

namespace Packimpex\ContentManager\Configuration\IRS\Bookings;

class StrategyMap 
{
	public static $strategy_map = array( 
										"permission_strategy" =>
											"Packimpex\ContentManager\Strategies\PermissionStrategy",
										"upload_strategy" => 
											"Packimpex\ContentManager\Strategies\UploadStrategy",
										"delete_strategy" => 
											"Packimpex\ContentManager\Strategies\DeleteStrategy",
										"download_strategy" => 
											"Packimpex\ContentManager\Strategies\DownloadStrategy");
}