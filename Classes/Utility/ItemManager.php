<?php
namespace YolfTypo3\SavLibraryKickstarter\Utility;

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
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Item manager
 *
 * @package SavLibraryKickstarter
 */
class ItemManager extends \ArrayObject
{

    /**
     *
     * @var mixed
     */
    protected $parentIndex;

    /**
     * Adds an item.
     *
     * @param mixed $item
     *            The item to add.
     *            return \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager
     */
    public function addItem($item)
    {
        if ($item === null) {
            $itemManager = GeneralUtility::makeInstance(ItemManager::class);
            $this->ksort();
            $count = $this->count();
            if ($count > 0) {
                $iterator = $this->getIterator();
                $iterator->seek($count - 1);
                $index = $iterator->key() + 1;
            } else {
                $index = 1;
            }
            $itemManager->parentIndex = $index;
            $this[$index] = $itemManager;
            return $this[$index];
        } elseif (is_numeric($item) || is_string($item)) {
            if (! $this->itemExists($item) || $this[$item] === null) {
                $itemManager = GeneralUtility::makeInstance(ItemManager::class);
                $itemManager->parentIndex = $item;
                $this[$item] = $itemManager;
            }
            return $this[$item];
        } else {
            foreach ($item as $key => $value) {
                if ($value instanceof \stdClass || is_array($value)) {
                    $itemManager = GeneralUtility::makeInstance(ItemManager::class);
                    $this[$key] = $itemManager->addItem($value);
                } else {
                    $this[$key] = $value;
                }
            }
            return $this;
        }
    }

    /**
     * Gets the item index.
     *
     * return mixed Ihe item index
     */
    public function getItemIndex()
    {
        return $this->parentIndex;
    }

    /**
     * Gets an item.
     *
     * @param mixed $itemKey
     *            The key of the item.
     *            return \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager
     */
    public function getItem($itemKey)
    {
        return $this[$itemKey];
    }

    /**
     * Gets an item.
     *
     * @param mixed $itemKey
     *            The key of the item.
     *            return \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager
     */
    public function getItemAndSetToZeroIfNull($itemKey)
    {
        $itemValue = $this->getItem($itemKey);
        if ($itemValue === null) {
            return 0;
        } else {
            return $itemValue;
        }
    }

    /**
     * Checks if an item exists.
     *
     * @param mixed $itemKey
     *            The key of the item.
     *            return \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager
     */
    public function itemExists($itemKey)
    {
        return $this->offsetExists($itemKey);
    }

    /**
     * Gets all items.
     *
     * return \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager
     */
    public function getItems()
    {
        return $this;
    }

    /**
     * Deletes an item.
     *
     * @param mixed $itemKey
     *            The key of the item to delete
     *            return none
     */
    public function deleteItem($itemKey)
    {
        unset($this[$itemKey]);
    }

    /**
     * Gets all items in an Array.
     *
     * return \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager
     */
    public function getItemsAsArray()
    {
        $result = [];
        foreach ($this->getItems() as $key => $item) {
            if ($item instanceof \ArrayObject) {
                $result[$key] = $item->getItemsAsArray();
            } else {
                $result[$key] = $item;
            }
        }
        return $result;
    }

    /**
     * Replaces an item.
     *
     * @param mixed $itemValues
     *            The item values to replace
     *            return none
     */
    public function replace($itemValues, $item = null)
    {
        if ($item === null) {
            $item = $this;
        }
        foreach ($itemValues as $key => $itemValue) {
            if (is_array($itemValue)) {
                if (! $item->itemExists($key)) {
                    $item->addItem($key)->addItem($itemValue);
                } else {
                    if ($item[$key] === null) {
                        $item->addItem($key)->addItem($itemValue);
                    } else {
                        $item->replace($itemValue, $item[$key]);
                    }
                }
            } else {
                $item[$key] = $itemValue;
            }
        }
    }

    /**
     * Replaces the items values in all element of this item.
     *
     * @param mixed $itemValues
     *            The item values to replace
     *            return none
     */
    public function replaceAll($itemValues)
    {
        foreach ($this as $key => $field) {
            $this->replace($itemValues, $this[$key]);
        }
    }

    /**
     * Delete and Replaces an item.
     *
     * @param mixed $itemValues
     *            The item values to replace
     *            return none
     */
    public function deleteAndReplace($itemValues, $item = null)
    {
        if ($item === null) {
            $item = $this;
        }
        foreach ($this as $key => $field) {
            $item->deleteItem($key);
        }
        $item->replace($itemValues, $item);
    }

    /**
     * Finds an item from a search key.
     *
     * @param mixed $searchKey
     *            The search key
     * @param mixed $value
     *            Value to find
     *            return \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager
     */
    public function find($searchKey, $value)
    {
        foreach ($this as $keyField => $field) {
            $fieldValue = $this->searchFieldValue($field, $searchKey);
            if ($fieldValue == $value) {
                return $this[$keyField];
            }
        }
        return null;
    }

    /**
     * Sorts the items by a search key.
     *
     * @param mixed $searchKey
     *            The search key
     *            return \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager
     */
    public function sortBy($searchKey)
    {
        $sortedKeys = [];
        $existingKeys = [];
        // Gets the keys
        foreach ($this as $keyField => $field) {
            $fieldValue = $this->searchFieldValue($field, $searchKey);

            if ($fieldValue === false) {
                $sortedKeys = [];
            } elseif (array_key_exists($fieldValue, $sortedKeys)) {
                // It should not happen
                $existingKeys[] = $keyField;
            } else {
                $sortedKeys[$fieldValue] = $keyField;
            }
        }

        // Sorts the array
        ksort($sortedKeys);
        $sortedKeys = array_merge($sortedKeys, $existingKeys);

        // Builds the sorted item array
        $item = [];
        foreach ($sortedKeys as $fieldKey) {
            $item[$fieldKey] = $this[$fieldKey];
        }

        // Replaces the item
        if (! empty($item)) {
            $this->exchangeArray($item);
        }
        return $this;
    }

    /**
     * Returns the item associated with a search key
     *
     * @param \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager $field
     *            The field to be searched
     * @param mixed $searchKey
     *            The search key
     *
     *            return mixed The searched item
     */
    protected function searchFieldValue($field, $searchKey)
    {
        if (is_array($searchKey)) {
            $fieldValue = $field;
            $lastKey = false;

            foreach ($searchKey as $key => $value) {
                $fieldValue = $fieldValue[$key];
                $lastKey = $value;
            }
            if (empty($lastKey)) {
                return false;
            } else {
                return $fieldValue[$lastKey];
            }
        } else {
            return $field[$searchKey];
        }
    }

    /**
     * Reindexes the array given a search key.
     *
     * @param mixed $searchKey
     *            The search key
     *
     *            return none
     */
    public function reIndex($searchKey)
    {
        $this->sortBy($searchKey);

        $counter = 1;
        if (is_array($searchKey)) {
            // Gets the keys
            foreach ($this as $field) {
                $field[key($searchKey)][current($searchKey)] = $counter ++;
            }
        } else {
            foreach ($this as $field) {
                $field[$searchKey] = $counter ++;
            }
        }
        // Builds a new reindexed array
        $counter = 1;
        $fields = [];
        foreach ($this as $field) {
            $fields[$counter ++] = $field;
        }
        $this->exchangeArray($fields);
    }

    /**
     * Reindexes the keys of an arrayObject.
     *
     * return none
     */
    public function reIndexKeys()
    {
        // Sorts the items
        $this->ksort();
        // Builds a new reindexed array
        $fields = [];
        foreach ($this as $field) {
            $fields[] = $field;
        }
        $this->exchangeArray($fields);
    }

    /**
     * Applies a user function recursively to the item.
     *
     * @param string $functionName
     *            The function to apply
     * @param \ArrayObject $item
     *            The item or sub-item.
     *            return none
     */
    public function walkItem($functionName, $arguments = null, $itemToWalk = null)
    {

        // Checks if the function is callable
        if (! is_callable($functionName)) {
            throw new \RuntimeException('The function "' . $functionName . '" is not callable!');
        }

        // Sets the $items variable
        if ($itemToWalk === null) {
            $items = $this;
        } else {
            $items = $itemToWalk;
        }

        foreach ($items as $key => $item) {
            if ($item instanceof \ArrayObject) {
                $items[$key] = $this->walkItem($functionName, $arguments, $item);
            } elseif (is_array($item)) {
                foreach ($item as $keySubItem => $subItem) {
                    $item[$keySubItem] = $this->walkItem($functionName, $arguments, $subItem);
                }
                $items[$key] = $item;
            } else {
                $items[$key] = call_user_func($functionName, $item, $key, $arguments);
            }
        }
        if ($itemToWalk === null) {
            return $this;
        } else {
            return $items;
        }
    }
}
?>
