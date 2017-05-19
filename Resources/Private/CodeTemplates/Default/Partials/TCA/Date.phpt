{namespace sav=SAV\SavLibraryKickstarter\ViewHelpers}

<f:if condition="{sav:function(name:'TYPO3VersionCompare', arguments:{version:'8',operator:'<'})}" >
<f:then>
'config' => [
    'type' => 'input', 
    'size' => '8',
    'max' => '20',
    'eval' => 'date',
    'checkbox' => '0',
    'default' => '0'
],
</f:then>
<f:else>
'config' => [
    'type' => 'input', 
    'renderType' => 'inputDateTime',    
    'eval' => 'date',  
    'default' => '0'     
],
</f:else>
</f:if>