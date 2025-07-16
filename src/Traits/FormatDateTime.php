<?php namespace Wongyip\PHPHelpers\Traits;

use DateTime;
use Exception;

/**
 * A product of tired to remember date formats.
 *
 * @method static string MySQL(DateTime|string|int $dateTime = null)           MySQL datetime: 1970-12-31 23:59:59
 * @method static string MySqlDate(DateTime|string|int $dateTime = null)       MySQL date only: 1970-12-31
 * @method static string MySqlTime(DateTime|string|int $dateTime = null)       MySQL time only: 23:59:59
 * @method static string Filename(DateTime|string|int $dateTime = null)        Windows Filename: 2010-12-31-23-59-59
 * @method static string FilenameCompact(DateTime|string|int $dateTime = null) Filename Compact: 20101231-235959
 * @method static string JavaScript(DateTime|string|int $dateTime = null)      Javascript date string: March 10, 2001, 23:59:59
 * @method static string ShortDate(DateTime|string|int $dateTime = null)       Short Date: 1970-12-31
 * @method static string SimpleDate(DateTime|string|int $dateTime = null)      Simple date string: Jan 1, 2013 (Tue)
 * @method static string SimpleDateTime(DateTime|string|int $dateTime = null)  Simple date/time string: Jan 1, 2013 (Tue) 1:59 PM
 * @method static string EnglishDate(DateTime|string|int $dateTime = null)     British style: January 1, 2013
 * @method static string Outlook(DateTime|string|int $dateTime = null)         Microsoft Outlook: Tuesday, June 24, 2014 1:59 PM
 */
trait FormatDateTime
{
    /**
     * Predefined formats.
     *
     * @var array|string[]
     */
    private static array $datetimeFormats = [
        'MySQL'           => 'Y-m-d H:i:s',
        'MySqlDate'       => 'Y-m-d',
        'MySqlTime'       => 'H:i:s',
        'Filename'        => 'Y-m-d-H-i-s',
        'FilenameCompact' => 'Ymd-His',
        'JavaScript'      => 'F j, Y, H:i:s',
        'ShortDate'       => 'Y-m-d',
        'SimpleDate'      => 'M j, Y (D)',
        'SimpleDateTime'  => 'M j, Y (D) g:i A',
        'EnglishDate'     => 'F j, Y',
        'Outlook'         => 'l, F j, Y g:i A',
    ];

    /**
     * Formatting a date/time.
     *
     * Argument $format can be the name of predefined format or a generic format
     * string.
     *
     * Skip $dateTime for the current date. It will be converted a `DateTime`
     * object for formatting in case of string. For integer, it will be treated
     * as a timestamp and format directly with the `date()` function.
     *
     * @param string $format
     * @param DateTime|string|int|null $dateTime
     * @return string|null
     */
    public static function dateTime(string $format, DateTime|string|int $dateTime = null): ?string
    {
        $format = key_exists($format, self::$datetimeFormats) ? self::$datetimeFormats[$format] : $format;

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
            try {
                return (new DateTime($dateTime))->format($format);
            }
            catch (Exception) {
                // Not going strict here, just let it go.
            }
        }
        return null;
    }

    /**
     * [DEV]
     *
     * Get an array of the given or current date/time in all predefined formats.
     *
     * @param DateTime|string|int|null $dateTime
     * @return array|string|null
     */
    public static function testFormatDateTime(DateTime|int|string $dateTime = null): array|string|null
    {
        return array_map(
            function ($format) use ($dateTime) {
                return self::dateTime($format, $dateTime);
            },
            self::$datetimeFormats
        );
    }
}