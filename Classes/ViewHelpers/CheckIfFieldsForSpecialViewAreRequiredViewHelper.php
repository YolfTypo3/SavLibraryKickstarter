<?php
namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers;

use SJBR\StaticInfoTables\Utility\ModelUtility;

/*
 * This script is part of the TYPO3 project - inspiring people to share! *
 * *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by *
 * the Free Software Foundation. *
 * *
 * This script is distributed in the hope that it will be useful, but *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN- *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General *
 * Public License for more details. *
 */

/**
 * A view helper to check if there are new fields created in an existing table.
 *
 * = Examples =
 *
 * <code title="CheckIfFieldsForSpecialViewAreRequired">
 * <sav:CheckIfFieldsForSpecialViewAreRequired extension="extension"/>
 * </code>
 *
 * Output:
 * true or false
 *
 * @package SavLibraryKickstarter
 * @subpackage ViewHelpers
 * @author Laurent Foulloy <yolf.typo3@orange.fr>
 * @version $Id:
 */
class CheckIfFieldsForSpecialViewAreRequiredViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     *
     * @param array $extension
     *            Extension
     * @param string $model
     *             Model
     * @return boolean
     * @author Laurent Foulloy <yolf.typo3@orange.fr>
     */
    public function render($extension, $model)
    {
        foreach ($extension['forms'] as $formKey => $form) {
            if (!empty($form['specialView'])) {
                $queryKey = $form['query'];
                if($extension['queries'][$queryKey]['mainTable'] == $model) {
                    return TRUE;
                }
            }
        }
        return FALSE;
    }
}
?>

