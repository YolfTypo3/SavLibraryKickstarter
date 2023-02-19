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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;

/**
 * A view helper which returns a file if its exists in the SAV Library Kickstarter
 * and the default one otherwise.
 *
 * = Examples =
 *
 * <code title="useDefault">
 * <sav:useDefault fileName="file to check" default="default file" />
 * </code>
 *
 * @package SavLibraryKickstarter
 */
class RenderViewHelper extends \TYPO3Fluid\Fluid\ViewHelpers\RenderViewHelper
{
    /**
     * @return mixed
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $content = parent::renderStatic($arguments, $renderChildrenClosure, $renderingContext);

        if(!empty($arguments['contentAs']))
        {
            $renderingContext->getVariableProvider()->add($arguments['contentAs'], $content);

            if(($content = $renderChildrenClosure()) !== NULL)
            {
                $renderingContext->getVariableProvider()->remove($arguments['contentAs']);
            }
        }

        return $content;
    }
}
