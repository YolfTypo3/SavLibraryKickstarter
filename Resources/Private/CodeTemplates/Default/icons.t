<f:comment>Create icon.gif</f:comment>
<sav:function name="copyFile" arguments="{
  source:'Resources/Private/CodeTemplates/Default/Resources/Icons/ext_icon.gif',
  destinationExtension:extension.general.1.extensionKey,
  destination:'ext_icon.gif',
  keepFile:1
}" />

<f:comment>Create the files icons</f:comment>
<f:for each="{extension.newTables}" as="table">
  <sav:function name="copyFile" arguments="{
    source:'Resources/Private/CodeTemplates/Default/Resources/Icons/{table.defIcon}.gif',
    destinationExtension:extension.general.1.extensionKey,
    destination:'Resources/Private/Icons/icon_{sav:BuildTableName(shortName:table.tablename, extensionKey:extension.general.1.extensionKey, mvc:mvc)}.gif'
  }" />
</f:for>

<f:comment>Create the plugin icon if the flag is set</f:comment>
<f:if condition="{extension.general.1.addWizardPluginIcon}">
<sav:function name="copyFile" arguments="{
  source:'Resources/Private/CodeTemplates/Default/Resources/Icons/ext_icon.gif',
  destinationExtension:extension.general.1.extensionKey,
  destination:'Resources/Private/Icons/icon_{extension.general.1.extensionKey->sav:function(name:\'removeUnderscore\')}.png',
  keepFile:1
}" />
</f:if>
