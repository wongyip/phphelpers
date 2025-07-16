<?php namespace Wongyip\PHPHelpers;

use Wongyip\PHPHelpers\Converters\ConvertToXML;

/**
 * @todo Merge into Format::class.
 */
class Convert
{
    /**
     * Convert the input object to XML string.
     * 
     * @param mixed $object
     * @return string
     */
    static function toXML($object)
    {
        return ConvertToXML::fromObject($object);
    }
}