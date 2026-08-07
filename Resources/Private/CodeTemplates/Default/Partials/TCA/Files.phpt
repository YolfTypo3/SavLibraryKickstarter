<f:alias map="{imagefile:'imagefile', mediafile:'mediafile', textfile:'textfile'}">
'config' => [
    'type' => 'file',
    'maxitems' => {f:if(condition:'{field.conf_files}', then:'{field.conf_files}', else:'1')},
    <f:if condition="{field.conf_files_type} == {imagefile}">
    'allowed' => 'common-image-types',
    </f:if>
    <f:if condition="{field.conf_files_type} == {mediafile}">
    'allowed' => 'common-media-types',
    </f:if> 
    <f:if condition="{field.conf_files_type} == {textfile}">
    'allowed' => 'common-text-types',
    </f:if>      
],
</f:alias>
