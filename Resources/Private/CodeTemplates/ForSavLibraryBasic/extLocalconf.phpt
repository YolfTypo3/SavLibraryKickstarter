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
    $typo3Version = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class);
    if (version_compare($typo3Version->getVersion(), '10.0', '<')) {
        <f:comment>For TYPO3 lower than 10</f:comment>
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            '{extension.general.1.vendorName}.{extension.general.1.extensionKey}',
            '{extension.forms->sav:utility.getItem()->sav:utility.getItem(key:'title')}',
            // Cachable controller actions    	
            [
                '{extension.forms->sav:utility.getItem()->sav:utility.getItem(key:'title')->sav:format.upperCamel()}' => '{extension.views->sav:utility.getItem()->sav:utility.getItem(key:'title')->sav:format.lowerCamel()}',
            ],
            // Non-cachable controller actions
            []
        );
    } else {
        <f:comment>For TYPO3 10 and greater</f:comment>
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            '{extension.general.1.extensionKey->sav:format.upperCamel()}',
            '{extension.forms->sav:utility.getItem()->sav:utility.getItem(key:'title')}',
            // Cachable controller actions    	
            [
                \{extension.general.1.vendorName}\{extension.general.1.extensionKey->sav:format.upperCamel()}\Controller\{extension.forms->sav:utility.getItem()->sav:utility.getItem(key:'title')->sav:format.upperCamel()}Controller::class => '{extension.views->sav:utility.getItem()->sav:utility.getItem(key:'title')->sav:format.lowerCamel()}',
            ],
            // Non-cachable controller actions
            []
        );
    }

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
!
    // Adds the page TSConfig for the Wizard Icon
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:{extension.general.1.extensionKey}/Configuration/TsConfig/Page/Mod/Wizards/NewContentElement.tsconfig">'
    );
</f:alias>
</f:if>
})();
</sav:utility.removeEmptyLines>
