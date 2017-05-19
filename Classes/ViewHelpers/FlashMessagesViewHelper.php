<?php
namespace SAV\SavLibraryKickstarter\ViewHelpers;

/*
 * This script belongs to the FLOW3 package "Fluid". *
 * *
 * It is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version. *
 * *
 * This script is distributed in the hope that it will be useful, but *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN- *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser *
 * General Public License for more details. *
 * *
 * You should have received a copy of the GNU Lesser General Public *
 * License along with the script. *
 * If not, see http://www.gnu.org/licenses/lgpl.html *
 * *
 * The TYPO3 project - inspiring people to share! *
 */

/**
 * View helper which renders the flash messages.
 *
 *
 * = Examples =
 *
 * <code title="Simple">
 * <f:renderFlashMessages />
 * </code>
 * Renders flash messages.
 *
 * <code title="Output with css class">
 * <f:renderFlashMessages class="specialClass" />
 * </code>
 *
 * Output:
 * <ul class="specialClass">
 * ...
 * </ul>
 *
 */
class FlashMessagesViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\FlashMessagesViewHelper
{

    /**
     * Initialize arguments
     *
     * @return void @api
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        if (version_compare(TYPO3_version, '7.0', '<')) {
            // Tries to register the queueIdentifier if it does not exist - compatiblity for TYPO3 6.2
            try {
                $this->registerArgument('queueIdentifier', 'string', 'Flash-message queue to use');
            } catch (\TYPO3\CMS\Fluid\Core\ViewHelper\Exception $e) {}
        }
    }
}

?>
