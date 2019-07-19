{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}

'config' => [
    'type'  => 'input',
    'renderType' => 'inputLink',
    'size'  => '15',
    'max' => '255',
    'checkbox'  => '',
    'eval'  => 'trim',
    <f:if condition="{extension.general.1.compatibility} > 0">     
    'wizards' => [
        '_PADDING'  => 2,
        'link'  => [
            'type'  => 'popup',
            'title' => 'Link',         
            'icon'  => 'actions-wizard-link',           
            'module' => [
                'name' => 'wizard_link',
                'urlParameters' => [             
                    'mode' => 'wizard',
                ]
            ],    
            'JSopenParams'  => 'height=300,width=500,status=0,menubar=0,scrollbars=1',
        ]
    ],
    </f:if>
],
