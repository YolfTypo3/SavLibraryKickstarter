{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}

'config' => [
    'type' => 'input',
     
    <f:if condition="{extension.general.1.compatibility} == 0">
    'renderType' => 'inputDateTime',
    </f:if>    
                               
    'eval' => 'date',
    
    <f:if condition="{extension.general.1.compatibility} > 0">
    'size' => 8,
    'max' => 20, 
    'checkbox' => '0', 
    </f:if>     
     
    'default' => '0'     
],
