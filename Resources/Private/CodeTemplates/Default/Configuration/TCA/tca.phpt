<sav:function name="removeEmptyLines">

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

<f:comment>Creates TCA/Overrides/tt_content.php</f:comment>
<sav:saveContentToFile content='<f:render partial="Configuration/TCA/Overrides/tt_content.phpt" arguments="{extension:extension}" />'
            extensionKey="{extension.general.1.extensionKey}" fileName="Configuration/TCA/Overrides/tt_content.php" directory="Configuration/TCA/Overrides"/>
     
<f:comment>Creates TCA/Overrides/sys_template.php if needed</f:comment>
<f:if condition="{mvc}">     
<sav:saveContentToFile content='<f:render partial="Configuration/TCA/Overrides/sys_template.phpt" arguments="{extension:extension}" />'
            extensionKey="{extension.general.1.extensionKey}" fileName="Configuration/TCA/Overrides/sys_template.php" directory="Configuration/TCA/Overrides"/>
</f:if> 
<f:if condition="{extension.general.1.addTypoScriptConfiguration}">     
<sav:saveContentToFile content='<f:render partial="Configuration/TCA/Overrides/sys_template.phpt" arguments="{extension:extension}" />'
            extensionKey="{extension.general.1.extensionKey}" fileName="Configuration/TCA/Overrides/sys_template.php" directory="Configuration/TCA/Overrides"/>
</f:if>          
</sav:function>
