<?php namespace Wongyip\PHPHelpers;

/**
 * @todo Review
 */
class CSS
{
    /**
     * Compose a space sepatated CSS classes string, for the HTML 'class' attribute.
     * 
     * @param string|string[] $original
     * @param string|string[] $add
     * @param string|string[] $remove
     * @return string
     */
    static function classAttribute($original, $add, $remove)
    {
        $classes = is_string($original) ? explode(' ', $original) : (is_array($original) ? $original : []); 
        
        // Add first
        if (!empty($add)) {
            $adds = is_array($add) ? $add : explode(' ', $add);
        }
        else {
            $adds = [];
        }
        
        // Then remove
        if (!empty($remove)) {
            $removes = is_array($remove) ? $remove : explode(' ', $remove);
        }
        else {
            $removes = [];
        }
        
        // Uniqie < Diff < Merge
        return implode(' ', array_unique(array_diff(array_merge($classes, $adds), $removes)));
    }
}