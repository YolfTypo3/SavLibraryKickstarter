<?php

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

namespace YolfTypo3\SavLibraryKickstarter\Upgrade;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use YolfTypo3\SavLibraryKickstarter\Managers\ConfigurationManager;
use YolfTypo3\SavLibraryKickstarter\Managers\SectionManager;

/**
 * Abstract upgrade manager
 *
 * @package SavLibraryKickstarter
 */
abstract class AbstractUpgradeManager implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * The extension key
     *
     * @var string
     */
    protected $extensionKey;

    /**
     * The configuration manager
     *
     * @var ConfigurationManager
     */
    protected $configurationManager;

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
     * Injects the configuration manager
     *
     * @param ConfigurationManager $configurationManager
     *            The configuration manager
     * @return void
     */
    public function injectConfigurationManager(ConfigurationManager $configurationManager)
    {
        $this->configurationManager = $configurationManager;
    }

    /**
     * Pre processing
     *
     * @param SectionManager $sectionManager
     *            The section manager
     * @return void
     */
    public function preProcessing(SectionManager $sectionManager)
    {}

    /**
     * Post processing.
     *
     * @param SectionManager $sectionManager
     *            The section manager
     *
     * @return void
     */
    public function postProcessing(SectionManager $sectionManager)
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
