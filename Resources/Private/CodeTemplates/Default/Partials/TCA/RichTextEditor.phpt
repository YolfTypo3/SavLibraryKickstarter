{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}

'config' => [
    'type' => 'text',
    'cols' => '30',
    'rows' => '5',
    
    <f:if condition="{extension.general.1.compatibility} == 0" >  
    'enableRichtext' => true,     
    </f:if> 
    
    <f:if condition="{extension.general.1.compatibility} > 0" >     
    'wizards' => [
        '_PADDING' => 2,
        'RTE' => [
            'notNewRecords' => 1,
            'RTEonly' => 1,
            'type'  => 'script',
            'title' => 'Full screen Rich Text Editing',
            'icon'  => 'actions-wizard-rte',
            'module' => [
                'name' => 'wizard_rte',
            ],
        ],
    ],
    </f:if>      
],

