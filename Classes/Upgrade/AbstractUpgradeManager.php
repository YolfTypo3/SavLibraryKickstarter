<?php
namespace YolfTypo3\SavLibraryKickstarter\Upgrade;

/**
 * Copyright notice
 *
 * (c) 2010 Laurent Foulloy <yolf.typo3@orange.fr>
 * All rights reserved
 *
 * This class is a backport of the corresponding class of FLOW3.
 * All credits go to the v5 team.
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 */

/**
 * Abstract upgrade manager
 *
 * @package SavLibraryKickstarter
 * @subpackage Upgrade
 * @version SVN: $Id$
 */
abstract class AbstractUpgradeManager
{

    /**
     * The extension key.
     *
     * @var string
     */
    protected $extensionKey;

    /**
     * Constructor.
     *
     * @param string $extensionKey
     *            The extension key
     * @return void
     */
    public function __construct($extensionKey)
    {
        $this->extensionKey = $extensionKey;
    }

    /**
     * Pre processing
     *
     * @return array none
     */
    public function preProcessing()
    {}

    /**
     * Post processing.
     *
     * @param \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager $sectionManager
     *            The section manager
     *
     * @return void
     */
    public function postProcessing($sectionManager)
    {}

    /**
     * Gets the extension key.
     *
     * @return string The extension key
     */
    public function getExtensionKey()
    {
        return $this->extensionKey;
    }
}
?>
