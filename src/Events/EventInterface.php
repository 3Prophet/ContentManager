<?php

namespace Packimpex\ContentManager\Events;

interface EventInterface
{
	public function trigger();
	
	public function isMacroEvent();
}