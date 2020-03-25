<?php

namespace BootstrapTemplate;

use BootstrapTemplate\Module\Tabs;

class BootstrapTemplate {

	private static function initObject( $classname, $args ) {
		$class = (new \ReflectionClass($classname))
			->newInstanceWithoutConstructor();

		call_user_func_array(array($class, "__construct"), $args);

		return $class;
	}

	static function navTabs() {
		return self::initObject('\BootstrapTemplate\Module\Tabs', func_get_args());
	}

	static function navAccordion() {
		return self::initObject('\BootstrapTemplate\Module\Accordion', func_get_args());
	}
}
