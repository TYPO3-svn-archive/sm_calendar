<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Smcalendar',
	'SM - Calendar'
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'SM - Calendar');

			t3lib_extMgm::addLLrefForTCAdescr('tx_smcalendar_domain_model_calendar', 'EXT:sm_calendar/Resources/Private/Language/locallang_csh_tx_smcalendar_domain_model_calendar.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_smcalendar_domain_model_calendar');
			$TCA['tx_smcalendar_domain_model_calendar'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:sm_calendar/Resources/Private/Language/locallang_db.xml:tx_smcalendar_domain_model_calendar',
					'label' => 'title',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
                    'sortby' => 'sorting',
                    'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
                    'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Calendar.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_smcalendar_domain_model_calendar.gif'
				),
			);

?>