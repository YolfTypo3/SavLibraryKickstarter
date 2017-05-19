<f:comment>Create icon.gif</f:comment>
<sav:function name="copyFile" arguments="{
  source:'Resources/Private/CodeTemplates/Default/Resources/Icons/ext_icon.gif',
  destinationExtension:extension.general.1.extensionKey,
  destination:'ext_icon.gif',
  keepFile:1
}" />

<f:comment>Create Extension.svf.gif</f:comment>
<f:alias
    map="{
        iconName:'{sav:getItem(
            value:{
                0:\'\',
                1:\'ExtensionPlus.svg\',
                2:\'ExtensionMvc.svg\',
                3:\'ExtensionBasic.svg\'},
            key:extension.general.1.libraryType)}'           
        }">
<sav:function name="copyFile" arguments="{
  source:'Resources/Private/CodeTemplates/Default/Resources/Icons/{iconName}',
  destinationExtension:extension.general.1.extensionKey,
  destination:'Resources/Public/Icons/Extension.svg'
}" />
</f:alias>

<f:comment>Create the files icons</f:comment>
<f:for each="{extension.newTables}" as="table">
  <sav:function name="copyFile" arguments="{
    source:'Resources/Private/CodeTemplates/Default/Resources/Icons/{table.defIcon}.gif',
    destinationExtension:extension.general.1.extensionKey,
    destination:'Resources/Public/Icons/icon_{sav:BuildTableName(shortName:table.tablename, extensionKey:extension.general.1.extensionKey, mvc:mvc)}.gif'
  }" />
</f:for>

<f:comment>Create the plugin icon if the flag is set</f:comment>
<f:if condition="{extension.general.1.addWizardPluginIcon}">
<sav:function name="copyFile" arguments="{
  source:'Resources/Private/CodeTemplates/Default/Resources/Icons/ext_icon.gif',
  destinationExtension:extension.general.1.extensionKey,
  destination:'Resources/Public/Icons/icon_{extension.general.1.extensionKey->sav:function(name:\'removeUnderscore\')}.png',
  keepFile:1
}" />
</f:if>
