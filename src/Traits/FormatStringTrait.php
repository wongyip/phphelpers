<?php namespace Wongyip\PHPHelpers\Traits;

trait FormatStringTrait
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
     * Make a phrase into "Smart Capitalized Format for Titles and Headers".
     *
     * @param string  $phrase        Input phrase.
     * @param array   $allLower      List of words in all lower-case, default ['a', 'an', 'the', 'and', 'of', 'at', 'by', 'on', 'for', 'in', 'into', 'onto'].
     * @param array   $allUpper      List of words in all upper-case, default ['ID'].
     * @param array   $doNotTouch    List of words that shall keep untouched, no default.
     * @param boolean $ignoreNonWord Skip words composed non-alphabet words, default true.
     * @throws \Exception
     * @return string
     */
    static function smartCaps($phrase, $allLower = null, $allUpper = null, $doNotTouch = null, $ignoreNonWord = true)
    {
        $allLower = is_array($allLower) ? $allLower : ['a', 'an', 'the', 'and', 'of', 'at', 'by', 'on', 'for', 'in', 'into', 'onto'];
        $allUpper = is_array($allUpper) ? $allUpper : ['ID'];
        if (is_string($phrase)) {
            $parts = preg_split('/\-|_|\s/', $phrase);
            foreach ($parts as $key => $part) {
                $parts[$key] = in_array(strtolower($part), $allLower)
                ? strtolower($part)
                : (in_array(strtoupper($part), $allUpper)
                    ? strtoupper($part)
                    : (!self::isWord($part) && $ignoreNonWord
                        ? $part
                        : ucfirst($part)
                        )
                    );
            }
            return !self::isWord($part[0]) && $ignoreNonWord ? implode(' ', $parts) : ucfirst(implode(' ', $parts));
        }
        return '';
    }
    
    /**
     * @param string $input
     * @return boolean
     */
    static function isWord($input)
    {
        if (preg_match("/^[a-z]*$/i", $input)) {
            return true;
        }
        return false;
    }
    
    /**
     * String indentation.
     *
     * @param string  $string    The input string
     * @param integer $depth     Levels of indentation.
     * @param integer $indentStr Indentation string, default 4 spaces.
     * @return string
     */
    static function indent($string, $depth = 1, $indentStr = null)
    {
        if (!empty($string)) {
            $indentStr = is_string($indentStr) ? $indentStr : str_repeat(' ', 4);
            $indent = str_repeat($indentStr, $depth);
            return preg_replace("/^/m", $indent, $string);
        }
        return $string;
    }
}