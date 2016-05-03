<?php
<sav:function name="removeEmptyLines">
if (!defined ('TYPO3_MODE')) {
 	die ('Access denied.');
}

<f:for each="{extension.newTables}" as="newTable">
	<f:alias map="{
		 model:'{sav:buildTableName(shortName:newTable.tablename, extensionKey:extension.general.1.extensionKey, mvc:mvc)}'
	}">
		<sav:saveContentToFile content='<f:render partial="Configuration/TCA/newTable.phpt" arguments="{_all}"  />'
 				extensionKey="{extension.general.1.extensionKey}" fileName="Configuration/TCA/{model}.php" />
	</f:alias>
</f:for>

<f:for each="{extension.existingTables}" as="table">
    <f:alias map="{
        model: '{table.tablename}'
    }">
        <sav:saveContentToFile content='<f:render partial="Configuration/TCA/existingTable.phpt" arguments="{table:table, model:model, extension:extension}" />'
            extensionKey="{extension.general.1.extensionKey}" fileName="Configuration/TCA/Overrides/{model}.php" directory="Configuration/TCA/Overrides"/>
    </f:alias>
</f:for>

</sav:function>
?>
