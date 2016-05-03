'config' => array(
    'type' => 'text',
    'cols' => '30',
    'rows' => '5',
    'wizards' => array(
        '_PADDING' => 2,
        'RTE' => array(
            'notNewRecords' => 1,
            'RTEonly' => 1,
            'type'  => 'script',
            'title' => 'Full screen Rich Text Editing',
            'icon'  => (version_compare(TYPO3_version, '7', '<') ? 'wizard_rte2.gif' : 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_rte.gif'),
            'module' => array(
                'name' => 'wizard_rte',
            ),
        ),
    ),
),
