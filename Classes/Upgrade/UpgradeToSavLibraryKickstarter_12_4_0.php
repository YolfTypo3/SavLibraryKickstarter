<?php

declare(strict_types=1);

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

use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use YolfTypo3\SavLibraryKickstarter\Managers\SectionManager;

/**
 * Upgrades the extension from the kickstarter
 *
 * @package Kickstarter
 */
final class UpgradeToSavLibraryKickstarter_12_4_0 extends AbstractUpgradeManager
{
    /**
     *
     * @var bool
     */
    protected bool $criticalError = false;

    /**
     *
     * @var array
     */
    protected array $allowedAttributes = [
        'format' => [
            'replaceBy' => 'dateFormat',
        ],
    ];

    /**
     * Pre processing
     *
     * @param SectionManager $sectionManager
     *            The section manager
     *            
     * @return void
     */
    public function preProcessing(SectionManager $sectionManager): void
    {
        $this->logger->log(LogLevel::NOTICE, sprintf(''));
        $this->logger->log(LogLevel::NOTICE, sprintf('Begin upgrade %s to sav_library_kickstarter_12_4_0.', $this->extensionKey));
    }

    /**
     * Post processing
     *
     * @param SectionManager $sectionManager
     *            The section manager
     *            
     * @return void
     */
    public function postProcessing(SectionManager $sectionManager): void
    {
        $this->logger->log(LogLevel::NOTICE, sprintf('End upgrade.'));
    }
    
    /**
     * Upgrades the general section.
     *
     * @param SectionManager $section
     *            The actual section
     *
     * @return SectionManager The modified section
     */
    public function upgradeGeneralSection(SectionManager $section): SectionManager
    {
        $typo3Version = GeneralUtility::makeInstance(Typo3Version::class);
        
        if ($typo3Version->getMajorVersion() === 11) {
            // Changes the library type
            $section->getItem(1)->replace([
                'compatibility' => '11x'
            ]);
        } else {
            // Changes the library type
            $section->getItem(1)->replace([
                'compatibility' => '12x'
            ]);
        }
        
        return $section;
    }
    
    /**
     * Upgrades the newTables section.
     *
     * @param SectionManager $section
     *            The actual section
     *
     * @return SectionManager The modified section
     */
    public function upgradeNewTablesSection(SectionManager $section): SectionManager
    {
        foreach($section as $tableKey => $table) {
            foreach($table->getItem('fields') as $field) {
                $this->processFieldConfiguration($field, $tableKey);
            }
        }

        return $section;
    }

    /**
     * Upgrades the existingTables section.
     *
     * @param SectionManager $section
     *            The actual section
     *
     * @return SectionManager The modified section
     */
    public function upgradeExistingTablesSection(SectionManager $section): SectionManager
    {
        foreach($section as $tableKey => $table) {
            foreach($table->getItem('fields') as $field) {
                $this->processFieldConfiguration($field, $tableKey);
            }
        }

        return $section;
    }

    /**
     * Processes the field configuration.
     *
     * @param SectionManager $field 
     *            The field to process
     * @param int $tableKey       
     *
     * @return void
     */
    protected function processFieldConfiguration(SectionManager $field, int $tableKey): void
    {
        $configuration = $field->getItem('configuration');
        if ($configuration === null) {
            return;
        }
        foreach($configuration as $fieldConfigurationKey => $fieldConfiguration) {
            // Replaces \; by a temporary tag
            $fieldConfiguration = str_replace('\;', '###!!!!!!###', $fieldConfiguration ?? '');
            $items = explode(';', $fieldConfiguration);
            $processedItems = [];
            foreach ($items as $itemKey => $item) {
                // Skips comments
                if (preg_match('/^\/\//', trim($item))) {
                    continue;
                }

                if (! empty(trim($item))) {
                    // Replaces the temporary tag by "\;"
                    $item = str_replace('###!!!!!!###', '\;', trim($item));

                    $position = strpos($item, '=');
                    if ($position === false) {
                        $this->logger->log(LogLevel::CRITICAL, sprintf('-> NewTables: missing equal sign in %s.', $item));
                    } else {
                        $attribute = strtolower(trim(substr($item, 0, $position)));
                        $value = ltrim(substr($item, $position + 1));

                        if (array_key_exists($attribute, $this->allowedAttributes)) {
                            if ($this->allowedAttributes[$attribute]['replaceBy'] === '') {
                                $this->logger->log(LogLevel::NOTICE, sprintf('-> NewTables #%d: the attribute <%s> in field <%s> is deprecated and was removed.', $tableKey, $attribute, $field->getItem('fieldname')));
                            } else {
                                $this->logger->log(LogLevel::NOTICE, sprintf('-> NewTables #%d: the attribute value was changed in attribute <%s>.', $tableKey, $attribute));
                                if (is_array($this->allowedAttributes[$attribute]['replaceBy'])) {
                                    $replaceBy = $this->allowedAttributes[$attribute]['replaceBy'][$field->getItem('type')];
                                } else {
                                    $replaceBy = $this->allowedAttributes[$attribute]['replaceBy'];
                                }
                                $processedItems[$itemKey] = $replaceBy . ' = '. $value;
                            }
                        } else {
                            $processedItems[$itemKey] = $item;
                        }
                    }
                }
            }

            if (! empty($processedItems)) {
                $configuration->replace([
                    $fieldConfigurationKey => implode(';' . chr(10), $processedItems) . ';'
                ]);
            }
        }
    }

}
