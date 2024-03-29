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
     * @param string $phrase         Input phrase.
     * @param array|null $allLower   List of words in all lower-case, default ['a', 'an', 'the', 'and', 'of', 'at', 'by', 'on', 'for', 'in', 'into', 'onto'].
     * @param array|null $allUpper   List of words in all upper-case, default ['ID'].
     * @param array|null $doNotTouch List of words that shall keep untouched, no default.
     * @param boolean $ignoreNonWord Skip words composed non-alphabet words, default true.
     * @return string
     */
    static function smartCaps(string $phrase, array $allLower = null, array $allUpper = null, array $doNotTouch = null, bool $ignoreNonWord = true): string
    {
        $allLower   = is_array($allLower) ? $allLower : ['a', 'an', 'the', 'and', 'of', 'at', 'by', 'on', 'for', 'in', 'into', 'onto'];
        $allUpper   = is_array($allUpper) ? $allUpper : ['ID'];
        $doNotTouch = is_array($doNotTouch) ? $doNotTouch : [];
        // Break into parts.
        $parts = preg_split('/-|_|\s/', $phrase);
        foreach ($parts as $key => $part) {
            $parts[$key] = in_array($part, $doNotTouch)
                ? $part
                : (in_array(strtolower($part), $allLower)
                    ? strtolower($part)
                    : (in_array(strtoupper($part), $allUpper)
                        ? strtoupper($part)
                        : (!self::isWord($part) && $ignoreNonWord
                            ? $part
                            : ucfirst($part)
                        )
                    )
                );
        }
        return trim(!self::isWord($parts[0]) && $ignoreNonWord ? implode(' ', $parts) : ucfirst(implode(' ', $parts)));

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