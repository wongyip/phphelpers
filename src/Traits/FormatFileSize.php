<?php namespace Wongyip\PHPHelpers\Traits;

use Exception;

/**
 * @see https://stackoverflow.com/a/14919494
 * @see https://en.wikipedia.org/wiki/File_size
 * @see https://physics.nist.gov/cuu/Units/prefixes.html
 */
trait FormatFileSize
{
    /**
     * Convert byte-size to human readable file size string.
     *
     * @param int $bytes File size in bytes.
     * @param bool|null $prefix Default to binary prefixes, insert any non-null value use metric prefixes (or SI prefixes, where kilo = 10^3).
     * @param bool|null $unit Default to strict units, insert any non-null value for casual unit.
     */
    public static function fileSize(int $bytes, bool $prefix = null, bool $unit = null, $precision = 2): string
    {
        try {
            return self::fileSizeStrict(max($bytes, 0), $prefix, $unit, $precision);
        }
        catch (Exception $e) {
            // Call fileSizeStrict() directly if you need an exception.
            return '0 Byte';
        }
    }

    /**
     * Convert byte-size to human readable file size.
     *
     * @param int $bytes File size in bytes.
     * @param bool|null $prefix Default to binary prefixes, insert any non-null value use metric prefixes (or SI prefixes, where kilo = 10^3).
     * @param bool|null $unit Default to strict units, insert any non-null value for casual unit.
     * @throws Exception
     */
    public static function fileSizeStrict(int $bytes, bool $prefix = null, bool $unit = null, $precision = 2): string
    {
        if ($bytes < 0) {
            throw new Exception(
                sprintf('Accept non-negative integer $bytes only, input: %d.', $bytes)
            );
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