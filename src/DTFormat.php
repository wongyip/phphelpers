<?php namespace Wongyip\PHPHelpers;

use DateTime;

/**
 * A product of tired to remember date formats.
 *
 * @author Yipli
 *
 * @method static string MySQL(DateTime|string|int $dateTime = null)           MySQL datetime: 1970-12-31 23:59:59
 * @method static string MySqlDate(DateTime|string|int $dateTime = null)       MySQL date: 1970-12-31
 * @method static string MySqlTime(DateTime|string|int $dateTime = null)       MySQL time: 23:59:59
 * @method static string Filename(DateTime|string|int $dateTime = null)        Windows Filename: 2010-12-31-23-59-59
 * @method static string FilenameCompact(DateTime|string|int $dateTime = null) Filename Compact: 20101231-235959
 * @method static string Javascript(DateTime|string|int $dateTime = null)      Javascript date string: March 10, 2001, 23:59:59
 * @method static string ShortDate(DateTime|string|int $dateTime = null)       Short Date: 1970-12-31
 * @method static string SimpleDate(DateTime|string|int $dateTime = null)      Simple date string: Jan 1, 2013 (Tue)
 * @method static string SimpleDateTime(DateTime|string|int $dateTime = null)  Simple date/time string: Jan 1, 2013 (Tue) 1:59 PM
 * @method static string EnglishDate(DateTime|string|int $dateTime = null)     British style: January 1, 2013
 * @method static string Outlook(DateTime|string|int $dateTime = null)         Microsoft Outlook: Tuesday, June 24, 2014 1:59 PM
 *
 * @deprecated Replaced by Format (FormatDateTime trait).
 */
class DTFormat
{
    /**
     * @var array|string[]
     */
    private static array $formats = [
        'MySQL'           => 'Y-m-d H:i:s',
        'MySqlDate'       => 'Y-m-d',
        'MySqlTime'       => 'H:i:s',
        'Filename'        => 'Y-m-d-H-i-s',
        'FilenameCompact' => 'Ymd-His',
        'Javascript'      => 'F j, Y, H:i:s',
        'ShortDate'       => 'Y-m-d',
        'SimpleDate'      => 'M j, Y (D)',
        'SimpleDateTime'  => 'M j, Y (D) g:i A',
        'EnglishDate'     => 'F j, Y',
        'Outlook'         => 'l, F j, Y g:i A',
        // Keep for b/w compatibility.
        'MySQLdate'       => 'Y-m-d',
        'MySQLtime'       => 'H:i:s',
    ];

    /**
     * Overloading.
     *
     * @param $name
     * @param $arguments
     * @return string|null
     */
    static function __callStatic($name, $arguments): ?string
    {
        if (key_exists($name, self::$formats)) {
            $dateTime = $arguments[0] ?? null;
            return self::format(self::$formats[$name], $dateTime);
        }
        return null;
    }

    /**
     * Actual payload.
     *
     * @param string $format
     * @param DateTime|string|int|null $dateTime
     * @return string|null
     */
    private static function format(string $format, $dateTime = null): ?string
    {
        if (is_null($dateTime)) {
            return date($format);
        }
        if ($dateTime instanceof DateTime) {
            return $dateTime->format($format);
        }
        if (is_int($dateTime)) {
            return date($format, $dateTime);
        }
        if (is_string($dateTime)) {
            if ($time = strtotime($dateTime)) {
                 return date($format, $time);
            }
        }
        return null;
    }

    /**
     * For test or demonstration.
     *
     * @param DateTime|string|int|null $dateTime
     * @return array|string[]
     */
    public static function all($dateTime = null): array
    {
        $output = [];
        foreach (self::$formats as $name => $format) {
            $output[$name] = self::format($format, $dateTime);
        }
        return $output;
    }
}
