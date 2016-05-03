<?php
<sav:function name="removeEmptyLines" arguments="{keepLine:'!'}"><f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:upperCamel()}',
    modelName:      '{extension.newTables->sav:getItem(key:itemKey)->sav:getItem(key:\'tablename\')->sav:upperCamel()}'
    fields:         '{extension.newTables->sav:getItem(key:itemKey)->sav:getItem(key:\'fields\')}'
}">
namespace {vendorName}\{extensionName}\Domain\Repository;
/**
*  Copyright notice
*
*  (c) <f:format.date format="Y">now</f:format.date> {extension.emconf.1.author} <{extension.emconf.1.author_email}>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
*/

/**
 * Repository for the {modelName} model in the extension {extensionName}
 *
 */
class {modelName}Repository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
!
}
?>
</f:alias>
</sav:function>
