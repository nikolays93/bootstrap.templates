<?php

use BootstrapTemplate\BootstrapTemplate;

require_once __DIR__ . '/../src/BootstrapTemplate.php';
require_once __DIR__ . '/../src/Module/Accordion.php';

include __DIR__ . '/../fixtures/navs.php';

$navAccordion = BootstrapTemplate::navAccordion(array('active' => 'chars'));

array_map(function($tab) use ($navAccordion) {

	$navAccordion->addItem($tab->name, $tab->title, function($name, $title) use ($tab) {
		printf('<%1$s>%2$s</%1$s>', 'h3', $title);
		echo $tab->content;
	});

}, $tabs);

$navAccordion->render();
