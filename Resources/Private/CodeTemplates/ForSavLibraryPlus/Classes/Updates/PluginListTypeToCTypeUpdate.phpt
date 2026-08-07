{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}<sav:utility.removeEmptyLines keepLine="!">
<?php
!
declare(strict_types=1);
!
<f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:format.upperCamel()}',
    extensionNameWithoutUnderscore: '{extension.general.1.extensionKey->sav:format.removeUnderscore()}',
    controllerName: '{extension.forms->sav:utility.getItem()->sav:utility.getItem(key:\'title\')->sav:format.upperCamel()}'
}">

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with TYPO3 source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
!
namespace {vendorName}\{extensionName}\Updates;
!
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use YolfTypo3\SavLibraryPlus\Updates\AbstractListTypeToCTypeUpdate;
!
#[UpgradeWizard('{extension.general.1.extensionKey->sav:format.lowerCamel()}_pluginListTypeToCTypeUpdate')]
/**
 * Upgrades for the '{extension.general.1.extensionKey}' extension.
 *
 * @author {extension.emconf.1.author} <{extension.emconf.1.author_email}>
 * @package {extension.general.1.extensionKey}
 */
final class PluginListTypeToCTypeUpdate extends AbstractListTypeToCTypeUpdate
{
!
    protected function getListTypeToCTypeMapping(): array
    {
        return [
            '{extension.general.1.extensionKey}_pi1' => '{extension.general.1.extensionKey}_pi1',
        ];
    }
!
    public function getTitle(): string
    {
        return 'Migrates {extension.general.1.extensionKey} plugin';
    }
!
    public function getDescription(): string
    {
        return 'Migrates {extension.general.1.extensionKey}_pi1 from list_type to CType. ';
    }
!
}
</f:alias>
</sav:utility.removeEmptyLines>