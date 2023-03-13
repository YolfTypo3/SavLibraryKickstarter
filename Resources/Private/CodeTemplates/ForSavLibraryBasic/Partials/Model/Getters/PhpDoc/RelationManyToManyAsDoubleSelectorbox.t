<f:if condition="{field.conf_relations_mm}">
<f:then>
@return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
</f:then>
<f:else>
@return array
</f:else>
</f:if>
