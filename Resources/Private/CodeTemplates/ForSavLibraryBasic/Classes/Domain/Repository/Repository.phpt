<?php
<sav:function name="removeEmptyLines" arguments="{keepLine:'!'}"><f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:upperCamel()}',
    modelName:      '{extension.newTables->sav:getItem(key:itemKey)->sav:getItem(key:\'tablename\')->sav:upperCamel()}',
    fields:         '{extension.newTables->sav:getItem(key:itemKey)->sav:getItem(key:\'fields\')}'
}">
namespace {vendorName}\{extensionName}\Domain\Repository;
!
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
/**
 * Repository for the {modelName} model in the extension {extensionName}
 *
 */
class {modelName}Repository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
!
}
</f:alias>
</sav:function>
