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
 * A view helper to check if there are new fields created in an existing table.
 *
 *
 * @package SavLibraryKickstarter
 */
final class CheckIfFieldsForSpecialViewAreRequiredViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('extension', 'array', 'Extension', true);
        $this->registerArgument('model', 'string', 'Model', true);
    }

    /**
     * Renders the view helper
     *
     * @return bool
     */
    public function render(): bool
    {
        // Gets the arguments
        $extension = $this->arguments['extension'];
        $model = $this->arguments['model'];

        if (is_array($extension['forms'])) {
            foreach ($extension['forms'] as $form) {
                if (! empty($form['specialView'])) {
                    $queryKey = $form['query'];
                    if ($extension['queries'][$queryKey]['mainTable'] == $model) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
}
