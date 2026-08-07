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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Builder\Documentation;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A view helper for rendering the type to build the documentation.
 *
 * = Examples =
 *
 * <code title="RenderSectionTitle">
 * <sav:documentation.renderSectionTitle title="My Title" level="0"/>
 * </code>
 *
 * Output:
 * ========
 * My Title
 * ========
 *
 * @package SavLibraryKickstarter
 */
final  class RenderSectionTitleViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('title', 'string', 'Title of teh section', false, null);
        $this->registerArgument('level', 'integer', 'level of the section', false, 0);
    }
    /**
     * Renders the view helper
     *
     * @return string
     */
    public function render(): string
    {

        // Gets the arguments
        $title = $this->arguments['title'];
        $level = $this->arguments['level'];

        if ($title === null) {
            $title = $this->renderChildren();
        }

        // Gets the title length
        $titleLength = strlen($title);

        $out = '';
        switch($level) {
            case 0:
                $decoration = '=';
                $out .= str_repeat($decoration, $titleLength) . chr(10);
                break;
            case 1:
                $decoration = '=';
                break;
            case 2:
                $decoration = '-';
                break;
        }
        $out .= $title . chr(10);
        $out .= str_repeat($decoration, $titleLength) . chr(10);

        return $out;
    }
}
