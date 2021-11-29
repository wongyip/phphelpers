<?php namespace Wongyip\PHPHelpers\Traits;

trait FormatFileSizeTrait
{
    /**
     * Convert byte-size to human readable file size.
     *
     * Modified from: https://stackoverflow.com/a/14919494
     * Reference: https://en.wikipedia.org/wiki/File_size
     * Reference: https://physics.nist.gov/cuu/Units/prefixes.html
     *
     * @param number  $bytes   File size in bytes.
     * @param boolean $prefix  Default to binary prefixes, insert any non-null value use metric prefixes (or SI prefixes, whiere kilo = 10^3).
     * @param boolean $unit    Default to strict units, insert any non-null value for casual unit.
     */
    static function fileSize($bytes, $prefix = null, $unit = null, $precision = 2)
    {
        if (!is_numeric($bytes) && $bytes >= 0) {
            throw new \Exception('Accept non-negative integer $bytes only, input: ' . $bytes);
        }
        
        // Options
        $binary = is_null($prefix);
        $strict = is_null($unit);
        $thresh = $binary ? 1024 : 1000;
        
        // No conversion is needed
        if (abs($bytes) < $thresh) {
            return $bytes . ' Bytes';
        }
        
        // Pick the units.
        $units = explode(
            ',',
            $binary
                ? ($strict ? self::WY_FILESIZE_UNITS_BINARY_STRICT : self::WY_FILESIZE_UNITS_BINARY_CASUAL)
                : ($strict ? self::WY_FILESIZE_UNITS_METRIC_STRICT : self::WY_FILESIZE_UNITS_METRIC_CASUAL)
        );
        
        // Do the calculations
        $u = -1;
        $output = $bytes;
        while (abs($output) >= $thresh & $u < count($units) - 1) {
            $output /= $thresh;
            $u++;
        }
        
        // Yo
        $output = round($output, $precision);
        return $output . ' ' . $units[$u];        
    }
}