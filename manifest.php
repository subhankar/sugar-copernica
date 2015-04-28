<?php

$manifest = array (
	0 =>
	array (
		'acceptable_sugar_versions' =>
		array (
			"exact_matches" => array(),
        	"regex_matches" => array(0 => "7\\.*\\.*"),
		),
	),
	1 =>
	array (
		'acceptable_sugar_flavors' =>
		array (
			0 => 'PRO',
		    1 => 'CORP',
		    2 => 'ENT',
		    3 => 'ULT',
		),
	),
	'readme' => 'SugarCRM 7 On Demand Version and Copernica Software. Copernica is an online multichannel platform to create professional marketing campaigns and engage your audience. Segment your database, create content and automate campaigns via email, web, mobile, social and print. ',
	'author' => 'Subhankar Das',
	'description' => 'Update Copernica Profile',
	'icon' => '',
	'is_uninstallable' => true,
	'name' => 'sync_Copernica',
	'published_date' => '2015-02-24',
	'type' => 'module',
	'version' => 1.0,
);


$installdefs = array(
	'id' => 'copernica_Hook',
	'mkdir' => array(
		array('path' => 'custom/modules/Accounts'),
	),
	'copy' => array (
		array (
			'from' => '<basepath>/Accounts/copernica_logic_hook.php',
			'to' => 'custom/modules/Accounts/copernica_logic_hook.php',
		),
	),
	'logic_hooks' => array(
		array(
			'module' => 'Accounts',
			'hook' => 'after_save',
			'order' => 96,
			'description' => 'Update related Copernica Profile',
			'file' => 'custom/modules/Accounts/copernica_logic_hook.php',
			'class' => 'copernica_class',
			'function' => 'updateCopernica',
		),
	),
);
?>