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
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Builder\Documentation;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use YolfTypo3\SavLibraryKickstarter\Managers\ConfigurationManager;

/**
 * A viewHelper for including the table of content
 *
 *
 * @package SavLibraryMvc
 */
final class IncludeTableOfContentsViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('extensionKey', 'string', 'Extension key', true);
        $this->registerArgument('nbSpace', 'int', 'Number of space prepended to each line', true);
    }

    /**
     * Renders the view helper
     *
     * @return string
     */
    public function render(): string
    {
        // Gets the arguments
        $extensionKey = $this->arguments['extensionKey'];
        $nbSpace = $this->arguments['nbSpace'];

        $extensionDirectory = ConfigurationManager::getExtensionDir($extensionKey);
        $fileName = $extensionDirectory . 'Documentation/TableOfContents.txt';

        if (file_exists($fileName)) {
            $lines = explode(chr(10), file_get_contents($fileName));
            $result =[];
            foreach ($lines as $line) {
                $result[] = str_repeat(' ', $nbSpace) . $line;
            }
            $content = implode(chr(10), $result);

            return $content;
        }

        return '';
    }
}
