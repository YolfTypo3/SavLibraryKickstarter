{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}<sav:utility.removeEmptyLines keepLine="!">
<?php
!
<f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:format.upperCamel()}',
    extensionNameWithoutUnderscore: '{extension.general.1.extensionKey->sav:format.removeUnderscore()}',
    controllerName: '{extension.forms->sav:utility.getItem()->sav:utility.getItem(key:\'title\')->sav:format.upperCamel()}'
}">
declare(strict_types=1);
!
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;
!
return [
    // Icon identifier
    'tx-{extensionNameWithoutUnderscore}-svgicon' => [
        // Icon provider class
        'provider' => SvgIconProvider::class,
        // The source SVG for the SvgIconProvider
        'source' => 'EXT:{extension.general.1.extensionKey}/Resources/Public/Icons/Extension.svg',
    ],
<f:if condition="{extension.general.1.addWizardPluginIcon}">
	'tx-{extensionNameWithoutUnderscore}-wizard' => [
	    // Icon provider class
        'provider' => SvgIconProvider::class,
        // The source SVG for the SvgIconProvider
        'source' => 'EXT:{extension.general.1.extensionKey}/Resources/Public/Icons/ExtensionWizard.svg'
    ],
</f:if>    
];
</f:alias>
</sav:utility.removeEmptyLines>