<?php

namespace Packimpex\ContentManager\Events;

abstract class AbstractMacroEvent implements EventInterface
{	
	/**
	 * @return boolean
	 */
	public function isMacroEvent()
	{
		return true;
	}
	
	/**
	 * @param Packimpex\ContentManager\Events\EventInterface $event
	 */
	public function addEvent($event)
	{
		array_push($this->events, $event);
	}
}