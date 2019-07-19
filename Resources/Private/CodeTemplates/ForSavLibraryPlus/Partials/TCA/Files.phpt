'config' =>	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
    	'{field.fieldname}',
    	[
        	'maxitems' => {f:if(condition:'{field.conf_files}', then:'{field.conf_files}', else:'1')},
        	'uploadfolder' => 'user_upload',
    	],        
<f:alias map="{images:'images', webimages:'webimages', all:'all'}"> 
<f:if condition="{field.conf_files_type} == {all}">
    	'',
</f:if>
<f:if condition="{field.conf_files_type} == {images}">
    	$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
</f:if>
<f:if condition="{field.conf_files_type} == {webimages}">
    	'gif,png,jpeg,jpg',
</f:if> 
<f:if condition="{field.conf_files_type} == {all}">
    	'php,php3'
</f:if>
<f:if condition="{field.conf_files_type} == {images}">
    	''
</f:if>
<f:if condition="{field.conf_files_type} == {webimages}">
    	''
</f:if>   
),
</f:alias>
