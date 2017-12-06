<?php
namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers;

/*
 * This script is part of the TYPO3 project - inspiring people to share! *
 * *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by *
 * the Free Software Foundation. *
 * *
 * This script is distributed in the hope that it will be useful, but *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN- *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General *
 * Public License for more details. *
 */
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use YolfTypo3\SavLibraryKickstarter\Utility\Conversion;
use YolfTypo3\SavLibraryKickstarter\Configuration\ConfigurationManager;
use YolfTypo3\SavLibraryKickstarter\ViewHelpers\FunctionViewHelper;
/**
 * A view helper for executing private functions.
 *
 * = Examples =
 *
 * <code title="function">
 * <sav:function name="upperCamel" arguments="tx_savlibraryexample_test" />
 * </code>
 *
 * Output:
 * TxSavlibraryexampleTest
 *
 * @package SavLibraryMvc
 * @subpackage ViewHelpers
 * @author Laurent Foulloy <yolf.typo3@orange.fr>
 * @version $Id:
 */
class FunctionViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     *
     * @param string $name
     *            The function name
     * @param mixed $arguments
     *            The arguments
     * @return string the type for the variable
     * @author Laurent Foulloy <yolf.typo3@orange.fr>
     * @version SVN: $Id$
     */
    public function render($name = NULL, $arguments = NULL)
    {
        $children = $this->renderChildren();
        if (! empty($children)) {
            if (method_exists($this, $name)) {
                $method = new \ReflectionMethod(FunctionViewHelper::class, $name);
                if (! $method->isPrivate()) {
                    throw new \RuntimeException('Only private method can be called. The method "' . $name . '" is not private !');
                } else {
                    return $this->$name($children, $arguments);
                }
            } else {
                throw new \RuntimeException('The function "' . $name . '" does not exist !');
            }
        } elseif (method_exists($this, $name)) {
            $method = new \ReflectionMethod(FunctionViewHelper::class, $name);
            if (! $method->isPrivate()) {
                throw new \RuntimeException('Only private method can be called. The method "' . $name . '" is not private !');
            } else {
                return $this->$name($arguments);
            }
        } else {
            throw new \RuntimeException('The function "' . $name . '" does not exist !');
        }
    }

    /**
     * Converts a string to utf8
     *
     * @param string $string
     *            The string to convert
     * @return string The string in utf8
     */
    private function stringToUtf8($string)
    {
        return Conversion::stringToUtf8($string);
    }

    /**
     * Converts a string to upperCamel
     *
     * @param string $string
     *            The string to convert
     * @return string The string in upper Camel case
     */
    private function upperCamel($string)
    {
        return Conversion::upperCamel($string);
    }

    /**
     * Converts a string to lowerCamel
     *
     * @param string $string
     *            The string to convert
     * @return string The string in lower Camel case
     */
    private function lowerCamel($string)
    {
        return Conversion::lowerCamel($string);
    }

    /**
     * Returns TRUE if the arguments is null
     *
     * @param mixed $argument
     *            The argument
     * @return mixed
     */
    private function setTrueIfNull($argument)
    {
        if (is_null($argument)) {
            return TRUE;
        } else {
            return $argument;
        }
    }

    /**
     * Returns 0 if the arguments is empty
     *
     * @param mixed $argument
     *            The argument
     * @return mixed
     */
    private function setZeroIfEmpty($argument)
    {
        if (empty($argument)) {
            return '0';
        } else {
            return $argument;
        }
    }

    /**
     * Returns TRUE if the arguments[index] in the argument[input] is an array of integer
     *
     * @param array $arguments
     *            The argument array
     * @return boolean
     */
    private function isArrayOfInteger($arguments)
    {
        $notInteger = 0;
        foreach ($arguments['input'] as $key => $value) {
            $notInteger += MathUtility::canBeInterpretedAsInteger($value[$arguments['index']]) ? 0 : 1;
        }
        return $notInteger ? FALSE : TRUE;
    }

    /**
     * Returns TRUE if the arguments[needle] is in the argument[haystack]
     *
     * @param array $arguments
     *            The argument array
     * @return boolean
     */
    private function in_array($arguments)
    {
        if (is_string($arguments['haystack'])) {
            $haystack = explode(',', $arguments['haystack']);
        } elseif (is_array($arguments['haystack'])) {
            $haystack = $arguments['haystack'];
        } else {
            return FALSE;
        }
        return in_array($arguments['needle'], $haystack);
    }

    /**
     * Returns the current value of an array
     *
     * @param array $argument
     *            The argument
     * @return mixed
     */
    private function current($argument)
    {
        if (is_array($argument)) {
            return current($argument);
        } else {
            return FALSE;
        }
    }

    /**
     * Returns TRUE if the argument is an array
     *
     * @param mixed $argument
     *            The argument
     * @return boolean
     */
    private function isArray($argument)
    {
        return is_array($argument);
    }

    /**
     * Returns TRUE if the argument is an integer
     *
     * @param mixed $argument
     *            The argument
     * @return boolean
     */
    private function isInteger($argument)
    {
        return is_integer($argument);
    }

    /**
     * Returns TRUE if the argument is a postive integer
     *
     * @param mixed $argument
     *            The argument
     * @return boolean
     */
    private function isPositiveInteger($argument)
    {
        return is_integer($argument) && ($argument > 0);
    }

    /**
     * Returns the md5 value of a string as integer
     *
     * @param string $string
     *            The argument
     * @return integer
     */
    private function md5int($string)
    {
        return GeneralUtility::md5int($string);
    }

    /**
     * Retmoves the underscore in a string
     *
     * @param string $string
     *            The argument
     * @return string
     */
    private function removeUnderscore($string)
    {
        return str_replace('_', '', $string);
    }

    /**
     * Counts the number of lines in a string
     *
     * @param string $string
     *            The argument
     * @return integer
     */
    private function countLines($string)
    {
        return substr_count($string, chr(10)) + 1;
    }

    /**
     * Removes empty lines in a string
     *
     * @param string $string
     *            The argument
     * @return string
     */
    private function removeEmptyLines($string, $arguments = NULL)
    {
        if ($arguments === NULL) {
            $string = preg_replace('/([ \t]*[\r\n]){2,}/', chr(10), $string);
        } else {
            $string = preg_replace('/([ \t]*[\r\n]){2,}/', chr(10), $string);
            $string = preg_replace('/' . $arguments['keepLine'] . '([ \t]*[\r\n]){1,2}/', chr(10), $string);
        }

        return $string;
    }

    /**
     * Removes CR-LF in a string
     *
     * @param string $string
     *            The argument
     * @return string
     */
    private function removeLineFeed($string)
    {
        $string = preg_replace('/[\n\r]+/', '', $string);
        return $string;
    }

    /**
     * Adds slashes
     *
     * @param string $string
     *            The argument
     * @return string
     */
    private function addSlashes($string)
    {
        $string = addslashes($string);
        return $string;
    }

    /**
     * Returns an empty string
     *
     * @return string
     */
    private function nothing()
    {
        return '';
    }

    /**
     * Returns the negation of an argument
     *
     * @param mixed $argument
     *            The argument
     * @return string
     */
    private function logicalNot($argument)
    {
        return $argument ? FALSE : TRUE;
    }

    /**
     * Returns the and of the arguments
     *
     * @param mixed $argument
     *            The argument
     * @return string
     */
    private function logicalAnd($arguments)
    {
        $result = TRUE;
        foreach ($arguments as $argument) {
            $result = $result && $argument;
        }
        return $result;
    }

    /**
     * Returns the or of the arguments
     *
     * @param mixed $arguments
     *            The argument
     * @return string
     */
    private function logicalOr($arguments)
    {
        $result = FALSE;
        foreach ($arguments as $argument) {
            $result = $result || $argument;
        }
        return $result;
    }

    /**
     * Returns an empty string
     *
     * @param mixed $argument
     *            The argument
     * @return string
     */
    private function not($arguments)
    {
        return $arguments ? FALSE : TRUE;
    }

    /**
     * Copies a file given by $arguments['source'] from the extension $arguments['sourceExtension']
     * into the file $arguments['destination'] from the extension $arguments['destinationExtension']
     *
     * @return void
     */
    private function copyFile($arguments)
    {
        if ($arguments['sourceExtension']) {
            $sourceExtensionDirectory = ConfigurationManager::getExtensionDir($arguments['sourceExtension']);
        } else {
            $sourceExtensionDirectory = ConfigurationManager::getExtensionDir('sav_library_kickstarter');
        }
        if ($arguments['destinationExtension']) {
            $destinationExtensionDirectory = ConfigurationManager::getExtensionDir($arguments['destinationExtension']);
        } else {
            $destinationExtensionDirectory = ConfigurationManager::getExtensionDir('sav_library_kickstarter');
        }
        if (empty($arguments['keepFile']) || ($arguments['keepFile'] && ! file_exists($destinationExtensionDirectory . $arguments['destination']))) {
            if (! @copy($sourceExtensionDirectory . $arguments['source'], $destinationExtensionDirectory . $arguments['destination'])) {
                throw new \RuntimeException('Copy failed.');
            }
        }
    }

    /**
     * Returns the time
     *
     * @return integer
     */
    private function time()
    {
        return time();
    }

    /**
     * Returns the substring
     *
     * @param string $string
     *            The string
     * @param integer $arguments
     *            The start argument
     *
     * @return string
     */
    private function substr($string, $arguments)
    {
        return substr($string, $arguments);
    }

    /**
     * Replaces all occurrences of the search string with the replacement string
     *
     * @param string $string
     *            The string
     * @param integer $arguments
     *            The start argument
     *
     * @return string
     */
    private function strReplace($string, $arguments)
    {
        return str_replace($arguments['search'], $arguments['replace'], $string);
    }


    /**
     * Compares
     *
     * @param mixed $argument
     *            The argument
     *
     * @return boolean
     */
    private function TYPO3VersionCompare($arguments)
    {
        return version_compare(TYPO3_version, $arguments['version'], $arguments['operator']);
    }
}
?>

