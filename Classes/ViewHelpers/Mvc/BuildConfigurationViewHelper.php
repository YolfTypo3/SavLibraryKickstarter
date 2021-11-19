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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Mvc;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A view helper for to build the view configuration.
 *
 * = Examples =
 *
 * <code title="BuildConfiguration">
 * <sav:Mvc.BuildConfiguration field="Myfield" />
 * Myfield->sav:Mvc.BuildConfiguration()
 * </code>
 *
 * Output:
 * The configuration
 *
 * @package SavLibraryKickstarter
 */
class BuildConfigurationViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('field', 'string', 'Configuration of the field', false, null);
    }

    /**
     * Renders the viewhelper
     *
     * @return array The configuration
     */
    public function render(): array
    {
        // Gets the arguments
        $field = $this->arguments['field'];

        if ($field === null) {
            $field = $this->renderChildren();
        }

        $configuration = [];

        // Replaces \; by a temporary tag
        $field = str_replace('\;', '#!!#', htmlspecialchars_decode($field));
        $items = explode(';', $field);

        foreach ($items as $item) {
            // Removes comments
            if (preg_match('/^\/\//', trim($item))) {
                continue;
            }

            if (trim($item)) {
                // Replaces the temporary tag by ;
                $item = str_replace('#!!#', ';', $item);

                $position = strpos($item, '=');
                if ($position === false) {
                    throw new \RuntimeException('Missing equal sign in ' . $item);
                } else {
                    $attributeName = trim(substr($item, 0, $position));

                    // Removes trailing spaces
                    $attributeValue = htmlspecialchars(ltrim(substr($item, $position + 1)));
                    $attributeValue = preg_replace('/\s+([\n\r])/', '$1', $attributeValue);
                    $configuration[$attributeName] = $attributeValue;
                }
            }
        }

        return $configuration;
    }
}
