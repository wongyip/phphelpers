<?php namespace Wongyip\PHPHelpers\Traits;

/**
 * @note Add toLine(), toCSV(), prettyPrint(), etc.
 */
trait FormatArray
{
    /**
     * Flatten the input arguments and return a plain array contains elements in
     * all input.
     *
     * @param mixed ...$elements
     * @return array
     */
    public static function flatten(mixed ...$elements): array
    {
        $flattened = [];
        array_walk_recursive($elements, function($a) use (&$flattened) { $flattened[] = $a; });
        return $flattened;
    }
}