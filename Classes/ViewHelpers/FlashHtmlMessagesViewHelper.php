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
 * View helper which renders the flash messages with HTML output.
 *
 * Same as FlashMessages but the output is not passed through htmlspecialchars.
 *
 *
 * = Examples =
 *
 * <code title="Simple">
 * <f:renderFlashHtmlessages />
 * </code>
 * Renders an ul-list of flash messages.
 *
 * <code title="Output with css class">
 * <f:renderFlashHtmlMessages class="specialClass" />
 * </code>
 *
 * Output:
 * <ul class="specialClass">
 * ...
 * </ul>
 *
 * @version $Id: RenderFlashHtmlMessagesViewHelper.php 1734 2009-11-25 21:53:57Z stucki $
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *          @scope prototype
 */
class FlashHtmlMessagesViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\FlashMessagesViewHelper
{

    /**
     * Renders the flash messages as unordered list
     *
     * @param array $flashMessages
     *            array<t3lib_FlashMessage>
     * @return string
     */
    protected function renderUl(array $flashMessages)
    {
        $this->tag->setTagName('ul');
        if ($this->hasArgumentCompatibleMethod('class')) {
            $this->tag->addAttribute('class', $this->arguments['class']);
        }
        $tagContent = '';
        foreach ($flashMessages as $singleFlashMessage) {
            $tagContent .= '<li>' . $singleFlashMessage->getMessage() . '</li>';
        }
        $this->tag->setContent($tagContent);
        return $this->tag->render();
    }

    /**
     * Gets the hasArgument method for compatiblity
     *
     * @param
     *            string argument
     * @return string
     */
    protected function hasArgumentCompatibleMethod($argument)
    {
        if (method_exists($this, 'hasArgument')) {
            // For 4.6 and higher
            return $this->hasArgument($argument);
        } else {
            // For 4.5
            return $this->arguments->hasArgument($argument);
        }
    }
}

?>
