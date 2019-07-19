<?php
namespace YolfTypo3\SavLibraryKickstarter\Upgrade;

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
use YolfTypo3\SavLibraryKickstarter\Utility\ItemManager;

/**
 * Abstract upgrade manager
 *
 * @package SavLibraryKickstarter
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
    public function __construct(string $extensionKey)
    {
        $this->extensionKey = $extensionKey;
    }

    /**
     * Pre processing
     *
     * @param \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager $sectionManager
     *            The section manager
     * @return void
     */
    public function preProcessing(ItemManager $sectionManager)
    {}

    /**
     * Post processing.
     *
     * @param \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager $sectionManager
     *            The section manager
     *            
     * @return void
     */
    public function postProcessing(ItemManager $sectionManager)
    {}

    /**
     * Gets the extension key.
     *
     * @return string The extension key
     */
    public function getExtensionKey(): string
    {
        return $this->extensionKey;
    }
}
?>
