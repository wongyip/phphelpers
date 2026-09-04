<?php namespace Wongyip\PHPHelpers\Traits;

use JsonSerializable;

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

    /**
     * Format $input to a multi-line text in "key: value" format and align the
     * position of the ":" across lines, support nested arrays.
     *
     * N.B. Arguments $included and $excluded are evaluated on the top level
     * elements only.
     *
     * @param array|JsonSerializable $input
     * @param array|null $included Include only these keys, NULL for all.
     * @param array|null $excluded Exclude these keys.
     * @param callable|null $keyFormatter
     * @param callable|null $valueFormatter
     * @param string|null $separator Default ': ' (colon and a space).
     * @param bool|null $suffixLineFeed At the end of the output, default: no.
     * @return string
     */
    public static function toText(
        array|JsonSerializable $input,
        ?array                 $included = null,
        ?array                 $excluded = null,
        ?callable              $keyFormatter = null,
        ?callable              $valueFormatter = null,
        ?string                $separator = null,
        ?bool                  $suffixLineFeed = null): string
    {
        // Make it an array.
        $input = $input instanceof JsonSerializable ? json_decode(json_encode($input), true) : $input;

        // Handle included/excluded keys.
        if (is_array($included)) {
            $input = array_intersect_key($input, array_flip($included));
        }
        if (is_array($excluded)) {
            $input = array_diff_key($input, array_flip($excluded));
        }

        // Prepare keys and formatters.
        $keys = array_keys($input);
        if ($keyFormatter) {
            $keys = array_map($keyFormatter, $keys);
        }

        // Find max key length for alignment.
        $maxKeyLen = 0;
        foreach ($keys as $k) {
            $maxKeyLen = max($maxKeyLen, mb_strlen($k));
        }

        // Build lines.
        $lines = [];
        $separator = $separator ?? ': ';
        foreach ($input as $key => $value) {

            $displayKey = $keyFormatter ? $keyFormatter($key) : $key;
            $padKey = str_pad($displayKey, $maxKeyLen);

            // Nested operation.
            if (is_array($value)) {
                $nested = static::toText($value, null, null, $keyFormatter, $valueFormatter, $separator);
                $lines[] = $padKey . $separator;
                // Indent nested lines.
                foreach (explode(PHP_EOL, $nested) as $nestedLine) {
                    $lines[] = '  ' . $nestedLine;
                }
            }
            else {
                $displayValue = $valueFormatter ? $valueFormatter($value) : $value;
                $lines[] = $padKey . $separator . $displayValue;
            }
        }

        return implode(PHP_EOL, $lines) . ($suffixLineFeed ? PHP_EOL : '');
    }
}