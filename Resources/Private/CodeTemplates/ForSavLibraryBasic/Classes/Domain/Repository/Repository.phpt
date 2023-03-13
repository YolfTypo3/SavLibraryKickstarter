<sav:utility.removeEmptyLines keepLine="!">
<?php
!
<f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:format.upperCamel()}',
    modelName:      '{extension.newTables->sav:utility.getItem(key:itemKey)->sav:utility.getItem(key:\'tablename\')->sav:format.upperCamel()}',
    fields:         '{extension.newTables->sav:utility.getItem(key:itemKey)->sav:utility.getItem(key:\'fields\')}'
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
namespace {vendorName}\{extensionName}\Domain\Repository;
!
/**
 * Repository for the {modelName} model in the extension {extensionName}
 *
 */
class {modelName}Repository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
!
}
</f:alias>
</sav:utility.removeEmptyLines>
