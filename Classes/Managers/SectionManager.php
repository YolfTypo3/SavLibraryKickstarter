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

namespace YolfTypo3\SavLibraryKickstarter\Managers;

/**
 * Section manager
 *
 * @package SavLibraryKickstarter
 */
final class SectionManager extends \ArrayObject
{

    /**
     *
     * @var \stdClass
     */
    protected $sections;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct($input = [])
    {
        $data = [];
        foreach ($input as $key => $value) {
            if (is_array($value)) {
                $value = new self($value);
            }
            $data[$key] = $value;
        }
        parent::__construct($data, \ArrayObject::ARRAY_AS_PROPS);
    }

    /**
     * Adds an item.
     *
     * @param mixed $item
     *            The item to add.
     * @return mixed
     */
    public function addItem($item)
    {
        if (is_array($item)) {
            foreach ($item as $key => $value) {
                $this[$key] = $value;
            }
            return $this;
        } else {
            if ($this->offsetExists($item)) {
                return $this[$item];
            } else {
                $this[$item] = new self();
                return $this[$item];
            }
        }
    }

    /**
     * Adds an empty item and gets the  key.
     *
     * @param mixed $item
     *            The item to add.
     * @return int
     */
    public function addEmptyItemAndGetKey()
    {
        $this->ksort();
        $count = $this->count();
        if ($count > 0) {
            // @extensionScannerIgnoreLine
            $iterator = $this->getIterator();
            $iterator->seek($count - 1);
            $index = $iterator->key() + 1;
         } else {
            $index = 1;
         }
         $this[$index] = new self();

         return $index;
    }

    /**
     * Gets an item.
     *
     * @param mixed $itemKey
     *            The key of the item.
     * @return mixed
     */
    public function getItem($itemKey)
    {
        return $this[$itemKey];
    }

    /**
     * Gets an item and sets it to 0 if null
     *
     * @param mixed $itemKey
     *            The key of the item.
     * @return mixed
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
     * @return bool
     */
    public function itemExists($itemKey): bool
    {
        return $this->offsetExists($itemKey);
    }

    /**
     * Gets all items.
     *
     * @return SectionManager
     */
    public function getItems(): ?SectionManager
    {
        return $this;
    }

    /**
     * Deletes an item.
     *
     * @param mixed $itemKey
     *            The key of the item to delete
     * @return void
     */
    public function deleteItem($itemKey)
    {
        unset($this[$itemKey]);
    }


    /**
     * Gets all items in an Array.
     *
     * @return array
     */
    public function getItemsAsArray(): array
    {
        $result = [];
        foreach ($this->getItems() as $key => $item) {
            if ($item instanceof \ArrayObject) {
                $result[$key] = $item->getItemsAsArray();
            } else {
                if (is_numeric($item)) {
                    $result[$key] = $item + 0;
                } else {
                    $result[$key] = $item;
                }
            }
        }
        return $result;
    }

    /**
     * Replaces an item.
     *
     * @param mixed $itemValues
     *            The item values to replace
     * @param mixed $item
     * @return void
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
     * @return void
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
     * @param mixed $item
     * @return void
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
     * @return mixed
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
     * @return SectionManager
     */
    public function sortBy($searchKey): SectionManager
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
     * @param SectionManager $field
     *            The field to be searched
     * @param mixed $searchKey
     *            The search key
     *
     * @return mixed The searched item
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
     * @return void
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
     * @return void
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
     * @return void
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