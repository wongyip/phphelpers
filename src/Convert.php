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
    public static function toXML(mixed $object): string
    {
        return ConvertToXML::fromObject($object);
    }
}