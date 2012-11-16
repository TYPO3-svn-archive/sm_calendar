<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_smcalendar_domain_model_calendar'] = array(
	'ctrl' => $TCA['tx_smcalendar_domain_model_calendar']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, i_cal_address, add_link, color',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, i_cal_address, add_link, color,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_smcalendar_domain_model_calendar',
				'foreign_table_where' => 'AND tx_smcalendar_domain_model_calendar.pid=###CURRENT_PID### AND tx_smcalendar_domain_model_calendar.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:sm_calendar/Resources/Private/Language/locallang_db.xml:tx_smcalendar_domain_model_calendar.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'i_cal_address' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:sm_calendar/Resources/Private/Language/locallang_db.xml:tx_smcalendar_domain_model_calendar.i_cal_address',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'add_link' => array(
			'exclude' => 0,
			//'label' => 'LLL:EXT:sm_calendar/Resources/Private/Language/locallang_db.xml:tx_smcalendar_domain_model_calendar.add_link',
			'label' => 'Add Link',
            'config' => array(
				'type' => 'passthrough',
			),
		),
		'color' => array(
			'exclude' => 0,
			//'label' => 'LLL:EXT:sm_calendar/Resources/Private/Language/locallang_db.xml:tx_smcalendar_domain_model_calendar.color',
			'label' => 'Farbe',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'wizards' => array(
                    'colorpick' => array(
                        'type' => 'colorbox',
                        'title' => 'Color picker',
                        'script' => 'wizard_colorpicker.php',
                        'dim' => '20x20',
                        'tableStyle' => 'border: solid 1px black; margin-left: 20px;',
                        'JSopenParams' => 'height=550,width=365,status=0,menubar=0,scrollbars=1',
                        'exampleImg' => 'gfx/wizard_colorpickerex.jpg',
                    )
                )
            ),
        ),
    ),
);

?>