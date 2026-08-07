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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Builder;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A view helper for building the table names.
 *
 *
 * @package SavLibraryKickstarter
 */
final class TableNameViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('extensionKey', 'string', 'Extension key', true);
        $this->registerArgument('shortName', 'string', 'Short name', false, '');
        $this->registerArgument('prefix', 'string', 'Prefix', false, '');
        $this->registerArgument('shortNameOnly', 'boolean', 'Short name only', false, false);
        $this->registerArgument('isMvc', 'boolean', 'Mvc flag', true);
    }

    /**
     * Renders the view helper
     *
     * @return string
     */
    public function render(): string
    {
        return self::renderTableName($this->arguments);
    }
    
    /**
     * Renders the table name
     *
     * @param array $arguments
     * 
     * @return string
     */
    public static function renderTableName(array $arguments): string
    {
        // Gets the arguments
        $extensionKey = $arguments['extensionKey'];
        $shortName = $arguments['shortName'];
        $prefix = $arguments['prefix'];
        $shortNameOnly = $arguments['shortNameOnly'];
        $isMvc = $arguments['isMvc'];
        
        if ($prefix != '') {
            $prefix = $prefix . '_';
        }
        if ($shortNameOnly === true) {
            return $shortName;
        } else {
            $domain = ($isMvc ? '_domain_model' : '');
            $defaultShortName = ($isMvc ? '_default' : '');
            return strtolower($prefix . 'tx_' . str_replace('_', '', $extensionKey) . $domain . ($shortName ? '_' . $shortName : $defaultShortName));
        }
    }
}
