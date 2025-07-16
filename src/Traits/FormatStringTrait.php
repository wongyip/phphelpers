<?php namespace Wongyip\PHPHelpers\Traits;

use Wongyip\HTML\Utils\Convert;
use Wongyip\PHPHelpers\Format;

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
     *
     * @deprecated
     */
	public static function camelCase(string $string, string $block_pattern = "/[a-z0-9]+/i"): string
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
     * convertInputToCamelCase
     *
     * @param string $input
     * @return string
     */
    public static function camel(string $input): string
    {
        return lcfirst(static::studly($input));
    }

    /**
     * @todo Review needed.
     *
     * @param string $input
     * @return boolean
     */
    private static function isWord(string $input): bool
    {
        if (preg_match("/^[a-z]+$/i", $input)) {
            return true;
        }
        return false;
    }

    /**
     * String indentation.
     *
     * @todo Review needed.
     *
     * @param string $string         The input string
     * @param integer $depth         Levels of indentation.
     * @param string|null $indentStr Indentation string, default 4 spaces.
     * @return string
     */
    public static function indent(string $string, int $depth = 1, string $indentStr = null): string
    {
        if (!empty($string)) {
            $indentStr = is_string($indentStr) ? $indentStr : str_repeat(' ', 4);
            $indent = str_repeat($indentStr, $depth);
            return preg_replace("/^/m", $indent, $string);
        }
        return $string;
    }

    /**
     * convert-input-to-kebab-case
     *
     * @param string $input
     * @return string
     */
    public static function kebab(string $input): string
    {
        return static::snake($input, '-');
    }

    /**
     * Convert the array keys naming scheme.
     *
     * @param array $array
     * @param string $case
     * @param string|null $prefix
     * @param string|null $suffix
     * @return array
     */
    public static function keysCase(array $array, string $case, string $prefix = null, string $suffix = null): array
    {
        $values = array_values($array);
        $keys  = array_keys($array);
        $keys  = array_map(fn($k) => $prefix . Format::$case($k) . $suffix, $keys);
        return array_combine($keys, $values);
    }

    /**
     * convert_input_to_snake_case
     *
     * @param string $input
     * @param string $delimiter
     * @return string
     */
    public static function snake(string $input, string $delimiter = '_'): string
    {
        // Nothing to convert.
        if (ctype_lower($input)) {
            return $input;
        }
        $input = preg_replace('/\s+/u', '', ucwords($input));
        $input = preg_replace('/(.)(?=[A-Z])/u', '$1' . $delimiter, $input);
        return mb_strtolower($input, 'UTF-8');
    }

    /**
     * ConvertInputToStudlyCase
     *
     * @param string $input
     * @return string
     */
    public static function studly(string $input): string
    {
        $words = explode(' ', str_replace(['-', '_'], ' ', $input));
        $studlyWords = array_map(fn ($word) => ucfirst($word), $words);
        return implode($studlyWords);
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
	public static function smartCaps(string $phrase, array $allLower = null, array $allUpper = null, array $doNotTouch = null, bool $ignoreNonWord = true): string
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
}