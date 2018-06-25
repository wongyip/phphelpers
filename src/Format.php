<?php namespace Wongyip\PHPHelpers;

class Format
{
    /**
     * Turn a string into camel-case style.
     * e.g. "Quick brown-fox jumps over the lazy dog!" >> "quickBrownFoxJumpsOverTheLazyDog"
     * 
     * Note that the default pattern break input into parts with any non-alphanumeric chars, and all such chars will be removed from output.
     * 
     * @param string $string
     * @param string $block_pattern
     * @return string
     */
    static function camelCase($string, $block_pattern = "/[a-z0-9]+/i")
    {
        $string = trim($string);
        $output = '';
        if (preg_match_all($block_pattern, $string, $matches)) {
            foreach ($matches[0] as $part){
                $output .= ucfirst(strtolower(trim($part)));
            }
            return lcfirst($output);
        }
        return strtolower($string);
    }
    
    /**
     * Make a phrase into "Smart Capitalized Format for Titles and Heeders".
     * 
     * This words are not capitalized by default: 'a', 'an', 'the', 'and', 'at', 'by', 'on', 'for', 'in', 'into' and 'onto'.
     * 
     * @param string $name
     * @param array $doNotCapitalize List of words that shall not be capitalized.
     * @throws \Exception
     * @return string
     */
    static function smartCaps($phrase, $doNotCapitalize = null)
    {
        $doNotCapitalize = is_array($doNotCapitalize) ? $doNotCapitalize : ['a', 'an', 'the', 'and', 'at', 'by', 'on', 'for', 'in', 'into', 'onto'];
        if (is_string($phrase)) {
            $parts = preg_split('/\-|_|\s/', $phrase);
            foreach ($parts as $key => $part) {
                $parts[$key] = in_array(strtolower($part), $doNotCapitalize) ? $part : ucfirst($part);
            }
            return ucfirst(implode(' ', $parts));
        }
        return '';
    }
}