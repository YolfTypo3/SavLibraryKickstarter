<f:format.raw><sav:utility.removeEmptyLines keepLine="!">
<?php
defined('TYPO3') or die();
!
// Default TypoScript
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    '{extension.general.1.extensionKey}', 
    'Configuration/TypoScript', 
    '{extension.general.1.pluginTitle->sav:format.toUtf8()}'
);
</sav:utility.removeEmptyLines></f:format.raw>