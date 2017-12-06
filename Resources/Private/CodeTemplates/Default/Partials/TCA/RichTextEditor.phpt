{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}

'config' => [
    'type' => 'text',
    'cols' => '30',
    'rows' => '5',
<f:if condition="{sav:function(name:'TYPO3VersionCompare', arguments:{version:'8',operator:'<'})}" >  
<f:then>    
    'wizards' => [
        '_PADDING' => 2,
        'RTE' => [
            'notNewRecords' => 1,
            'RTEonly' => 1,
            'type'  => 'script',
            'title' => 'Full screen Rich Text Editing',
            'icon'  => (version_compare(TYPO3_version, '7', '<') ? 'wizard_rte2.gif' : 'actions-wizard-rte'),
            'module' => [
                'name' => 'wizard_rte',
            ],
        ],
    ],
</f:then>
<f:else>
    'enableRichtext' => true,  
</f:else>
</f:if>      
],

