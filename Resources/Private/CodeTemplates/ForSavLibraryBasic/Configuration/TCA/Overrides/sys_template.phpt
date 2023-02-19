{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}<?php
defined('TYPO3') or die();
<f:format.raw><sav:function name="removeEmptyLines" arguments="{keepLine:'!'}">
// Default TypoScript
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    '{extension.general.1.extensionKey}', 
    'Configuration/TypoScript', 
    '{extension.general.1.pluginTitle->sav:function(name:'stringToUtf8')}'
);
</sav:function></f:format.raw>
