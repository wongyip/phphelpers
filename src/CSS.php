<?php namespace Wongyip\PHPHelpers;

/**
 * @todo Review
 */
class CSS
{
    /**
     * Compose a space separated CSS classes string, for the HTML 'class' attribute.
     *
     * @param string|array $original
     * @param string|array $add
     * @param string|array $remove
     * @return string
     */
    public static function classAttribute(string|array $original, string|array $add, string|array $remove): string
    {
        $classes = is_string($original) ? explode(' ', $original) : $original;

        // Add first
        $adds = empty($add) ? [] : (is_array($add) ? $add : explode(' ', $add));

        // Then remove
        $removes = empty($remove) ? [] : (is_array($remove) ? $remove : explode(' ', $remove));

        // Unique < Diff < Merge
        return implode(' ', array_unique(array_diff(array_merge($classes, $adds), $removes)));
    }
}