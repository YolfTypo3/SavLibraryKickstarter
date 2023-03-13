
<f:for each="{extension.newTables}" as="table">
	<f:alias map="{
        model:'{sav:builder.tableName(shortName:table.tablename, extensionKey:extension.general.1.extensionKey, mvc:mvc)}',
        modelForMM:'{sav:builder.tableName(shortName:table.tablename, extensionKey:extension.general.1.extensionKey, mvc:0)}'
	}">
		<sav:file.saveContentToFile 
            content='<f:render partial="Configuration/TCA/newTable.phpt" arguments="{_all}"  />'
            extensionKey="{extension.general.1.extensionKey}" 
            fileName="Configuration/TCA/{model}.php" 
        />
	</f:alias>
</f:for>

<f:for each="{extension.existingTables}" as="table">
    <f:alias map="{
        model: '{table.tablename}'
    }">
        <sav:file.saveContentToFile 
            content='<f:render partial="Configuration/TCA/existingTable.phpt" arguments="{_all}" />'
            extensionKey="{extension.general.1.extensionKey}" 
            fileName="{model}.php" 
            directory="Configuration/TCA/Overrides"
        />
    </f:alias>
</f:for>

<f:comment>Creates TCA/Overrides/tt_content.php</f:comment>
<sav:file.saveContentToFile 
    content='<f:render partial="Configuration/TCA/Overrides/tt_content.phpt" arguments="{extension:extension}" />'
    extensionKey="{extension.general.1.extensionKey}" 
    fileName="tt_content.php" 
    directory="Configuration/TCA/Overrides"
/>
     
<f:if condition="{mvc}">  
<f:comment>Creates TCA/Overrides/sys_template.php if needed</f:comment>   
<sav:file.saveContentToFile content='<f:render partial="Configuration/TCA/Overrides/sys_template.phpt" arguments="{extension:extension}" />'
    extensionKey="{extension.general.1.extensionKey}" 
    fileName="sys_template.php" 
    directory="Configuration/TCA/Overrides"
/>

<f:comment>Creates TCA/Overrides/tx_savlibrarymvc_domain_model_configuration.php</f:comment>
<sav:file.saveContentToFile 
    content='<f:render partial="Configuration/TCA/Overrides/tx_savlibrarymvc_domain_model_configuration.phpt" arguments="{extension:extension}" />'
    extensionKey="{extension.general.1.extensionKey}" 
    fileName="tx_savlibrarymvc_domain_model_configuration.php" 
    directory="Configuration/TCA/Overrides"
/>

</f:if> 

<f:if condition="{extension.general.1.addTypoScriptConfiguration}">     
<sav:file.saveContentToFile 
    content='<f:render partial="Configuration/TCA/Overrides/sys_template.phpt" arguments="{extension:extension}" />'
    extensionKey="{extension.general.1.extensionKey}" 
    fileName="sys_template.php" 
    directory="Configuration/TCA/Overrides"
/>
</f:if>          

