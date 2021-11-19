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

use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use YolfTypo3\SavLibraryKickstarter\Utility\Conversion;
use YolfTypo3\SavLibraryKickstarter\Managers\ConfigurationManager;

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
 *
 */
class FunctionViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('name', 'string', 'Name of the function', true);
        $this->registerArgument('arguments', 'mixed', 'arguments of the function', false);
    }

    /**
     * Renders the function
     *
     * @return mixed
     */
    public function render()
    {
        // Gets the arguments
        $name = $this->arguments['name'];
        $arguments = $this->arguments['arguments'];

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
    private function stringToUtf8(string $string = null): string
    {
        return ($string === null ? '' : Conversion::stringToUtf8($string));
    }

    /**
     * Converts a string to upperCamel
     *
     * @param string $string
     *            The string to convert
     * @return string The string in upper Camel case
     */
    private function upperCamel(string $string = null): string
    {
        return ($string === null ? '' : Conversion::upperCamel($string));
    }

    /**
     * Converts a string to lowerCamel
     *
     * @param string $string
     *            The string to convert
     * @return string The string in lower Camel case
     */
    private function lowerCamel(string $string = null): string
    {
        return ($string === null ? '' : Conversion::lowerCamel($string));
    }

    /**
     * Returns true if the arguments is null
     *
     * @param mixed $argument
     *            The argument
     * @return mixed
     */
    private function setTrueIfNull($argument)
    {
        if (is_null($argument)) {
            return true;
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
     * Returns true if the arguments[index] in the argument[input] is an array of integer
     *
     * @param array $arguments
     *            The argument array
     * @return bool
     */
    private function isArrayOfInteger(array $arguments): bool
    {
        $notInteger = 0;
        if (is_array($arguments['input'])) {
            foreach ($arguments['input'] as $value) {
                $notInteger += MathUtility::canBeInterpretedAsInteger($value[$arguments['index']]) ? 0 : 1;
            }
        }
        return $notInteger ? false : true;
    }

    /**
     * Returns true if the arguments[needle] is in the argument[haystack]
     *
     * @param array $arguments
     *            The argument array
     * @return bool
     */
    private function in_array(array $arguments): bool
    {
        if (is_string($arguments['haystack'])) {
            $haystack = explode(',', $arguments['haystack']);
        } elseif (is_array($arguments['haystack'])) {
            $haystack = $arguments['haystack'];
        } else {
            return false;
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
            return false;
        }
    }

    /**
     * Returns true if the argument is an array
     *
     * @param mixed $argument
     *            The argument
     * @return bool
     */
    private function isArray($argument): bool
    {
        return is_array($argument);
    }

    /**
     * Returns true if the argument is an integer
     *
     * @param mixed $argument
     *            The argument
     * @return bool
     */
    private function isInteger($argument): bool
    {
        return is_integer($argument);
    }

    /**
     * Returns true if the argument is a postive integer
     *
     * @param mixed $argument
     *            The argument
     * @return bool
     */
    private function isPositiveInteger($argument): bool
    {
        return is_integer($argument) && ($argument > 0);
    }

    /**
     * Returns the number of elements in an array
     *
     * @param mixed $argument
     *            The argument
     * @return integer
     */
    private function count($argument): int
    {
        return count($argument);
    }

    /**
     * Returns the length of a string
     *
     * @param string $string
     *            The argument
     * @return integer
     */
    private function strlen(string $string): int
    {
        return strlen($string);
    }


    /**
     * Returns the md5 value of a string as integer
     *
     * @param string $string|null
     *            The argument
     * @return integer
     */
    private function md5int($string): string
    {
        $string == $string ?? '';
        return GeneralUtility::md5int($string);
    }

    /**
     * Removes the underscore in a string
     *
     * @param string $string
     *            The argument
     * @return string
     */
    private function removeUnderscore(string $string = null): string
    {
        return str_replace('_', '', $string);
    }

    /**
     * Counts the number of lines in a string
     *
     * @param string $string
     *            The argument
     * @return int
     */
    private function countLines(string $string = null): int
    {
        if ($string === null) {
            return 0;
        } else {
            return substr_count($string, chr(10)) + 1;
        }
    }

    /**
     * Removes empty lines in a string
     *
     * @param string $string
     *            The argument
     * @param array $arguments
     * @return string
     */
    private function removeEmptyLines(string $string, array $arguments = null): string
    {
        if ($arguments === null) {
            $string = preg_replace('/([ \t]*[\r\n]){2,}/', chr(10), $string);
        } else {
            $string = preg_replace('/([ \t]*[\r\n]){2,}/', chr(10), $string);
            $string = preg_replace('/' . $arguments['keepLine'] . '([ \t]*[\r\n]){1,2}/', chr(10), $string);
        }
        if ($arguments['htmlentitiesDecode']) {
            $string = html_entity_decode($string, ENT_QUOTES);
        }
        return $string;
    }

    /**
     * Removes CR-LF in a string
     *
     * @param string|null $string
     *            The argument
     * @param array $arguments
     * @return string
     */
    private function removeLineFeed($string, array $arguments = null): string
    {
        if ($string === null) {
            return '';
        } else {
            $replacement = '';
            if (isset($arguments['replacement'])) {
                $replacement = str_replace('\\n', chr(10), $arguments['replacement']);
            }
            return preg_replace('/[\n\r]+/', $replacement, $string);
        }
    }

    /**
     * Adds slashes
     *
     * @param string $string
     *            The argument
     * @return string
     */
    private function addSlashes(string $string = null): string
    {
        $string = addslashes($string);
        return $string;
    }

    /**
     * Repeats a string
     *
     * @param string $string
     *            The string to repeat
     * @param string $arguments
     *            The number of times
     * @return string
     */
    private function strRepeat(string $string , string $arguments): string
    {

        if (!is_numeric($arguments)) {
            $arguments = strlen($arguments);
        }
        return str_repeat($string , $arguments);
    }


    /**
     * Returns an empty string
     *
     * @return string
     */
    private function nothing(): string
    {
        return '';
    }

    /**
     * Returns the negation of an argument
     *
     * @param mixed $argument
     *            The argument
     * @return bool
     */
    private function logicalNot($argument): bool
    {
        return $argument ? false : true;
    }

    /**
     * Returns the and of the arguments
     *
     * @param mixed $argument
     *            The argument
     * @return bool
     */
    private function logicalAnd($arguments): bool
    {
        $result = true;
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
     * @return bool
     */
    private function logicalOr($arguments): bool
    {
        $result = false;
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
     * @return bool
     */
    private function not($arguments): bool
    {
        return $arguments ? false : true;
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
     * Creates a directory
     *
     * @return void
     */
    private function mkdir($arguments)
    {
        GeneralUtility::mkdir_deep($arguments['extension'].$arguments['directory']);
    }

    /**
     * Writes data into a file
     *
     * @return void
     */
    private function filePutContents($arguments)
    {
        file_put_contents($arguments['filename'], $arguments['data']);
    }

    /**
     * Returns the time
     *
     * @return int
     */
    private function time(): int
    {
        return time();
    }

    /**
     * Returns the substring
     *
     * @param string $string
     *            The string
     * @param int $arguments
     *            The start argument
     *
     * @return string
     */
    private function substr(string $string, int $arguments): string
    {
        return substr($string, $arguments);
    }

    /**
     * Replaces all occurrences of the search string with the replacement string
     *
     * @param string $string
     *            The string
     * @param array $arguments
     *            The start argument
     *
     * @return string
     */
    private function strReplace(string $string, array $arguments): string
    {
        return str_replace($arguments['search'], $arguments['replace'], $string);
    }

    /**
     * Compares
     *
     * @param array $argument
     *            The argument
     *
     * @return bool
     */
    private function TYPO3VersionCompare(array $arguments): bool
    {
        return version_compare(GeneralUtility::makeInstance(Typo3Version::class)->getVersion(), $arguments['version'], $arguments['operator']);
    }

    /**
     * Returns a left brace
     *
     * @param string $string
     * @return string
     */
    private function leftBrace(string $string = null): string
    {
        return '{';
    }

    /**
     * Returns a right brace
     *
     * @param string $string
     * @return string
     */
    private function rightBrace(string $string = null): string
    {
        return '}';
    }
}
