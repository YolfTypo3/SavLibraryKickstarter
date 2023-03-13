<sav:utility.removeEmptyLines keepLine="!">
<?php
defined('TYPO3') or die();
!
(function () {
<f:for each="{extension.newTables}" as="table">
<f:if condition="{table.save_and_new}">
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('options.saveDocNew.{table.tablename}=1');
</f:if>
</f:for>
!
    // Configures the Dispatcher
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        '{extension.general.1.extensionKey->sav:format.upperCamel()}',
        '{extension.general.1.pluginName->sav:format.upperCamel()}',
        // Cachable controller actions      
        [
            // The first controller and its first action will be the default
            <f:for each="{extension.forms}" as="form">
            \{extension.general.1.vendorName}\{extension.general.1.extensionKey->sav:format.upperCamel()}\Controller\{form->sav:utility.getItem(key:'title')->sav:format.upperCamel()}Controller::class => 'list,single,edit,save,delete,deleteInSubform,upInSubform,downInSubform,deleteFile,export,exportSubmit',
            </f:for>
        ],
            // Non-cachable controller actions
        [
            <f:for each="{extension.forms}" as="form">
            \{extension.general.1.vendorName}\{extension.general.1.extensionKey->sav:format.upperCamel()}\Controller\{form->sav:utility.getItem(key:'title')->sav:format.upperCamel()}Controller::class => '{f:if(condition:form.listViewNotCached,then:'list,')}{f:if(condition:form.singleViewNotCached,then:'single,')}edit,save,delete,deleteInSubform,upInSubform,downInSubform,deleteFile,export,exportSubmit',
            </f:for>            
        ]
    );
<f:if condition="{extension.general.1.addWizardPluginIcon}">
!
<f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:format.upperCamel()}',
    controllerName: '{extension.forms->sav:utility.getItem()->sav:utility.getItem(key:\'title\')->sav:format.upperCamel()}'
}">
    // Registers the icon
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\Imaging\IconRegistry::class
    );
    $iconRegistry->registerIcon(
        'ext-{extensionName->sav:format.toLower()}-wizard',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        ['source' => 'EXT:{extension.general.1.extensionKey}/Resources/Public/Icons/ExtensionWizard.svg']
    );
</f:alias>
</f:if>
})();
</sav:utility.removeEmptyLines>