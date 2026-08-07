{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}<f:format.raw><sav:utility.removeEmptyLines keepLine="!">
<?php
!
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
!
defined('TYPO3') or die();
!
// Default TypoScript
ExtensionManagementUtility::addStaticFile(
    '{extension.general.1.extensionKey}', 
    'Configuration/TypoScript', 
    '{extension.general.1.pluginTitle->sav:format.toUtf8()}'
);
</sav:utility.removeEmptyLines></f:format.raw>