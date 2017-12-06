<?php
namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Link;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * A view helper for creating anchors.
 *
 * = Examples =
 *
 * <code title="empty">
 * <f:link.empty key="test" />
 * </code>
 *
 * Output:
 *
 * @package SavLibraryKickstarter
 * @subpackage ViewHelpers
 */
class EmptyViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     *
     * @param string $key
     *            target page. See TypoLink destination
     * @return string Rendered anchor
     * @author Laurent Foulloy <yolf.typo3@orange.fr>
     */
    public function render($key)
    {
        $output = '<a name="' . GeneralUtility::md5int($key) . '"></a>';
        
        return $output;
    }
}

?>
