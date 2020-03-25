<?php

use BootstrapTemplate\BootstrapTemplate;

require_once __DIR__ . '/../src/BootstrapTemplate.php';
require_once __DIR__ . '/../src/Module/Tabs.php';

include __DIR__ . '/../fixtures/tabs.php';

$navTabs = BootstrapTemplate::navTabs(array('active' => 'chars'));

array_map(function($tab) use ($navTabs) {

	$navTabs->addTab($tab->name, $tab->title, function($name, $title) use ($tab) {
		printf('<%1$s>%2$s</%1$s>', 'h3', $title);
		echo $tab->content;
	});

}, $tabs);

$navTabs->render();
