<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Smcalendar',
	array(
		'Calendar' => 'list',
		
	),
	// non-cacheable actions
	array(
		'Calendar' => '',
		
	)
);

if (!is_array($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations'][$_EXTKEY])) {
	$TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations'][$_EXTKEY] = array();
}

?>