<f:comment>Creates Extension.svg</f:comment>
<f:alias map="{
    iconName:'{sav:utility.getItem(
        value:{
            0:\'\',
            1:\'ExtensionPlus.svg\',
            2:\'ExtensionMvc.svg\',
            3:\'ExtensionBasic.svg\'},
        key:extension.general.1.libraryType)}'           
}">

    <sav:file.copyFile
        source="Resources/Public/Icons/{iconName}"
        destinationExtension="{extension.general.1.extensionKey}"
        destination="Resources/Public/Icons/Extension.svg"
    />

</f:alias>

<f:comment>Creates the files icons</f:comment>
<f:for each="{extension.newTables}" as="table">
    <sav:file.copyFile
        source="Resources/Private/CodeTemplates/Default/Resources/Icons/{table.defIcon}.gif"
        destinationExtension="{extension.general.1.extensionKey}"
        destination="Resources/Public/Icons/icon_{sav:builder.tableName(shortName:table.tablename, extensionKey:extension.general.1.extensionKey, mvc:mvc)}.gif"
    />
</f:for>

<f:comment>Creates the plugin icon if the flag is set</f:comment>
<f:if condition="{extension.general.1.addWizardPluginIcon}">
    <sav:file.copyFile
        source="Resources/Private/CodeTemplates/Default/Resources/Icons/ext_icon.gif"
        destinationExtension="{extension.general.1.extensionKey}"
        destination="Resources/Public/Icons/icon_{extension.general.1.extensionKey->sav:format.removeUnderscore()}.png"
        doNotCopyIfDestinationExists="1"
    />
</f:if>
