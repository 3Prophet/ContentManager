<?php

namespace Packimpex\ContentManager\Configuration\IRS\Bookings;

class GroupPermissionMap
{
	/**
	 * @var array A map [user_group_id => permissions_array]
	 */
	public static $group_permission_map = array( 1 => array(),
											2 => array('edit', 'view'),
											3 => array('view'),
											4 => array(),
											5 => array('edit', 'view', 'delete', 'upload'),
											6 => array('view'));
}