<?php

namespace Packimpex\ContentManager\Events;

abstract class AbstractEvent implements EventInterface
{
	/**
	 * @return boolean
	 */
	public function isMacroEvent()
	{
		return false;
	}
}