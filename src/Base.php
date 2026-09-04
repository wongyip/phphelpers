<?php namespace Wongyip\PHPHelpers;

use Exception;
use SimpleXMLElement;

/**
 * Base Object
 * No constructor, no property.
 *
 * @deprecated
 */
#[\AllowDynamicProperties]
class Base
{
    /**
     * Inherit properties from given object.
     * NOTE: error not handled if input array with numeric-key.
     *
     * @param mixed $object may be an object or array
     * @param bool $create_not_exists default true, set to false to ignore non-exist properties.
     * @return bool
     */
    public function inheritProperties(mixed $object, bool $create_not_exists = true): bool
    {
        $object = is_object($object) ? $object : (is_array($object) ? (object) $object : null);
        if (!is_null($object)) {
            if ($create_not_exists) {
                foreach (get_object_vars($object) as $key => $value) {
                    $this->$key = $value;
                }
            }
            else {
                foreach (get_object_vars($object) as $key => $value) {
                    if (property_exists($this, $key)) {
                        $this->$key = $value;
                    }
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Inherit selected properties from given object.
     *
     * @param mixed $object may be an object or array
     * @param array $properties simple array of property names or array keys for searching
     * @return bool
     * @throws Exception
     */
    public function inheritSelectedProperties(mixed $object, array $properties): bool
    {
        $object = is_object($object) ? $object : (is_array($object) ? (object) $object : null);
        if (!is_null($object)) {
            foreach ($properties as $key) {
                if (property_exists($this, $key)) {
                    if (property_exists($object, $key)) {
                        $this->$key = $object->$key;
                    }
                }
                else {
                    throw new Exception("Selected key: $key is not a property of current object.");
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Inherit an SimpleXMLElement's attributes (NOT node text) as properties.
     *
     * @param SimpleXMLElement $node
     * @param bool $create_not_exists default true, set to false to ignore non-exist properties.
     * @return bool
     */
    public function inheritXmlAttributes(SimpleXMLElement $node, bool $create_not_exists = true): bool
    {
        $attributes = $node->attributes();
        if ($attributes) {
            if ($create_not_exists) {
                foreach ($attributes as $key => $val) {
                    $this->$key = $val->__toString();
                }
            }
            else {
                foreach ($attributes as $key => $val) {
                    if (property_exists($this, $key)) {
                        $this->$key = $val->__toString();
                    }
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Update object property if exists.
     *
     * @param object|array $data
     * @param bool $update_null_value
     * @return bool
     */
    public function updateProperties(mixed $properties, bool $update_null_value = true): bool
    {
        $properties = is_object($properties) ? $properties : (is_array($properties) ? (object) $properties : null);
        if (!is_null($properties)) {
            foreach (get_object_vars($properties) as $key => $value) {
                if (property_exists($this, $key)) {
                    if (!is_null($value) || $update_null_value) {
                        $this->$key = $value;
                    }
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Convert $this to an Associative Array recursively. Private properties were not being exported.
     *
     * Inspired by victorbstan/php_object_to_array.php
     * @see http://gist.github.com/victorbstan/744478
     * @return array|null
     */
    public function toArray(): ?array
    {
        return json_decode(json_encode($this), true);
    }
}
