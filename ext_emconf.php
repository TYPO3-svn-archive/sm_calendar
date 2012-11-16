<?php

########################################################################
# Extension Manager/Repository config file for ext "sm_calendar".
#
# Auto generated 16-11-2012 15:02
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'SM - Calendar',
	'description' => '',
	'category' => 'plugin',
	'author' => '',
	'author_email' => '',
	'author_company' => '',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '0.0.0',
	'constraints' => array(
		'depends' => array(
			'extbase' => '1.3',
			'fluid' => '1.3',
			'typo3' => '4.5-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:37:{s:21:"ExtensionBuilder.json";s:4:"66c1";s:12:"ext_icon.gif";s:4:"e922";s:17:"ext_localconf.php";s:4:"7481";s:14:"ext_tables.php";s:4:"789c";s:14:"ext_tables.sql";s:4:"3fdc";s:41:"Classes/Controller/CalendarController.php";s:4:"6865";s:33:"Classes/Domain/Model/Calendar.php";s:4:"1cee";s:48:"Classes/Domain/Repository/CalendarRepository.php";s:4:"7241";s:46:"Classes/ViewHelpers/CalendarBodyViewHelper.php";s:4:"560f";s:57:"Classes/ViewHelpers/CalendarListPerspectiveViewHelper.php";s:4:"e2dc";s:44:"Configuration/ExtensionBuilder/settings.yaml";s:4:"335b";s:30:"Configuration/TCA/Calendar.php";s:4:"78ca";s:38:"Configuration/TypoScript/constants.txt";s:4:"af24";s:34:"Configuration/TypoScript/setup.txt";s:4:"d5e2";s:40:"Resources/Private/Language/locallang.xml";s:4:"2bfd";s:80:"Resources/Private/Language/locallang_csh_tx_smcalendar_domain_model_calendar.xml";s:4:"aa1a";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"538f";s:38:"Resources/Private/Layouts/Default.html";s:4:"a1ee";s:46:"Resources/Private/Templates/Calendar/List.html";s:4:"2fca";s:30:"Resources/Public/Icons/Add.gif";s:4:"9000";s:37:"Resources/Public/Icons/arrow_left.gif";s:4:"1caa";s:38:"Resources/Public/Icons/arrow_right.gif";s:4:"e62f";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";s:62:"Resources/Public/Icons/tx_smcalendar_domain_model_calendar.gif";s:4:"905a";s:28:"Resources/Public/css/PIE.htc";s:4:"3b8f";s:32:"Resources/Public/css/default.css";s:4:"7329";s:44:"Resources/Public/img/tooltip/black_arrow.png";s:4:"d62c";s:51:"Resources/Public/img/tooltip/black_arrow_bottom.png";s:4:"596b";s:31:"Resources/Public/js/calendar.js";s:4:"5550";s:39:"Resources/Public/js/jquery-1.7.2.min.js";s:4:"e61e";s:36:"Resources/Public/js/jquery-cookie.js";s:4:"5932";s:39:"Resources/Public/js/jquery.tools.min.js";s:4:"08a5";s:51:"Tests/Unit/Controller/AppointmentControllerTest.php";s:4:"16c2";s:48:"Tests/Unit/Controller/CalendarControllerTest.php";s:4:"f4f9";s:43:"Tests/Unit/Domain/Model/AppointmentTest.php";s:4:"6921";s:40:"Tests/Unit/Domain/Model/CalendarTest.php";s:4:"1138";s:14:"doc/manual.sxw";s:4:"8d2d";}',
);

?>