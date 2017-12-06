{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}

<f:if condition="{sav:function(name:'TYPO3VersionCompare', arguments:{version:'7',operator:'<'})}" >  
<f:then> 
'config' => [
    'type'  => 'input',
    'size'  => '15',
    'max' => '255',
    'checkbox'  => '',
    'eval'  => 'trim',
    'wizards' => [
        '_PADDING'  => 2,
        'link'  => [
            'type'  => 'popup',
            'title' => 'Link',         
            'icon'  => 'link_popup.gif',           
            'module' => [
                'name' => 'wizard_element_browser',
                'urlParameters' => [             
                    'mode' => 'wizard',
                ]
            ],    
            'JSopenParams'  => 'height=300,width=500,status=0,menubar=0,scrollbars=1',
        ]
    ],
],
</f:then>
<f:else>
'config' => [
    'type'  => 'input',
    'renderType' => 'inputLink',
    'size'  => '15',
    'max' => '255',
    'checkbox'  => '',
    'eval'  => 'trim',
<f:if condition="{sav:function(name:'TYPO3VersionCompare', arguments:{version:'8',operator:'<'})}" >     
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
</f:else>
</f:if>