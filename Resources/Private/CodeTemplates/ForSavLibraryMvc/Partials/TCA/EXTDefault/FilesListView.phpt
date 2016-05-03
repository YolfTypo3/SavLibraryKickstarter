<f:alias map="{images:'images', webimages:'webimages', all:'all'}">
<f:if condition="{field.conf_files_type} == {images}">
'imageFiles' => 1,
</f:if>
<f:if condition="{field.conf_files_type} == {webimages}">
'imageFiles' => 1,
</f:if>
</f:alias>


