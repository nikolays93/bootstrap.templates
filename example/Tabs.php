<?php

use BootstrapTemplate\BootstrapTemplate;

if( ! is_file('../vendor/autoload.php') || ! require_once '../vendor/autoload.php' ) {
	require_once __DIR__ . '/../src/BootstrapTemplate.php';
	require_once __DIR__ . '/../src/Module/Tabs.php';
}

include __DIR__ . '/../fixtures/navs.php';

$navTabs = BootstrapTemplate::navTabs(array('active' => 'chars'));

array_map(function($tab) use ($navTabs) {

	$navTabs->addItem($tab->name, $tab->title, function($name, $title) use ($tab) {
		printf('<%1$s>%2$s</%1$s>', 'h3', $title);
		echo $tab->content;
	});

}, $tabs);

$navTabs->render();
