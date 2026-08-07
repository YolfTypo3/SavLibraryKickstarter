{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}<sav:utility.removeEmptyLines keepLine="!">
<?php

<f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:format.upperCamel()}',
    extensionNameWithoutUnderscore: '{extension.general.1.extensionKey->sav:format.removeUnderscore()}',
    controllerName: '{extension.forms->sav:utility.getItem()->sav:utility.getItem(key:\'title\')->sav:format.upperCamel()}'
}">
!
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
!
defined('TYPO3') or die();
!
(function () {
<sav:file.saveContentToFile
    content='<f:render partial="{sav:file.getTemplateFile(templateFilePath:\'Configuration/user.tsconfigt\', extension:extension)}" arguments="{extension:extension}" />'
    extensionKey="{extension.general.1.extensionKey}"
    fileName="user.tsconfig"
    directory="Configuration"
    doNotCreateIfFileExists="{true}"
/>
!
    // Configures the Dispatcher
    ExtensionUtility::configurePlugin(
        '{extension.general.1.extensionKey->sav:format.upperCamel()}',
        '{extension.general.1.pluginName->sav:format.upperCamel()}',
        // Cachable controller actions    	
        [
            \{extension.general.1.vendorName}\{extension.general.1.extensionKey->sav:format.upperCamel()}\Controller\{extension.forms->sav:utility.getItem()->sav:utility.getItem(key:'title')->sav:format.upperCamel()}Controller::class => '{extension.views->sav:utility.getItem()->sav:utility.getItem(key:'title')->sav:format.lowerCamel()}',
        ],
        // Non-cachable controller actions
        [],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );


})();
</f:alias>
</sav:utility.removeEmptyLines>
