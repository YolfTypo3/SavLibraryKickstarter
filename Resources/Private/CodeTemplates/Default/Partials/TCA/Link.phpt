'config' => array (
    'type'  => 'input',
    'size'  => '15',
    'max' => '255',
    'checkbox'  => '',
    'eval'  => 'trim',
    'wizards' => array(
        '_PADDING'  => 2,
        'link'  => array(
            'type'  => 'popup',
            'title' => 'Link',
            'icon'  => (version_compare(TYPO3_version, '7', '<') ? 'link_popup.gif' : 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_link.gif'),           
            'module' => array(
                'name' => (version_compare(TYPO3_version, '7', '<') ? 'wizard_element_browser' : 'wizard_link'),
                'urlParameters' => array(             
                    'mode' => 'wizard',
                )
            ),    
            'JSopenParams'  => 'height=300,width=500,status=0,menubar=0,scrollbars=1',
        )
    ),
),
