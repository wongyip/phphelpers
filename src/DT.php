<?php namespace Wongyip\PHPHelpers;

/**
 * A product of tired to remember date formats.
 * @author Yipli
 */
class DT
{
    /**
     * Get date string in MySQL datetime format.
     * e.g. 1970-12-31 23:59:59
     * @return string
     */
    static function MySQL($dt = null)
    {
        $format = 'Y-m-d H:i:s';
        return self::format($format, $dt);
    }
    /**
     * Get date string in MySQL date (only) format.
     * e.g. 1989-06-04
     * @return string
     */
    static function MySQLdate($dt = null)
    {
        $format = 'Y-m-d';
        return self::format($format, $dt);
    }
    /**
     * Get date string in MySQL time (only) format.
     * e.g. 23:59:59
     * @return string
     */
    static function MySQLtime($dt = null)
    {
        $format = 'H:i:s';
        return self::format($format, $dt);
    }
    /**
     * Get date string in generice OS-safe format.
     * e.g. 2010-12-31-23-59-59
     * @return string
     */
    static function Filename($dt = null)
    {
        $format = 'Y-m-d-H-i-s';
        return self::format($format, $dt);
    }
    /**
     * Get date string in Javascript date string format.
     * e.g. March 10, 2001, 23:59:59
     * @return string
     */
    static function Javascript($dt = null)
    {
        $format = 'F j, Y, H:i:s';
        return self::format($format, $dt);
    }
    /**
     * Get date string in my favourite format.
     * e.g. 2010-12-31
     * @return string
     */
    static function ShortDate($dt = null)
    {
        $format = 'Y-m-d';
        return self::format($format, $dt);
    }
    /**
     * Get date string in British style.
     * e.g. January 1, 2013
     * @return string
     */
    static function EnglishDate($dt = null)
    {
        $format = 'F j, Y';
        return self::format($format, $dt);
    }
    /**
     * Get date string in (my) Microsoft Outlook format.
     * e.g. Tuesday, June 24, 2014 1:59 PM
     * @return string
     */
    static function Outlook($dt = null)
    {
        $format = 'l, F j, Y h:s A';
        return self::format($format, $dt);
    }
    /**
     * WHo actually do the work.
     * @param string $format
     * @param \DateTime $dt
     * @throws \Exception
     * @return string
     */
    static function format($format, $dt = null)
    {
        if (!is_string($format)) {
            throw new \Exception('Invalid data-type of $format, expected string.');
        }
        if ($dt && $dt instanceof \DateTime) {
            return $dt->format($format);
        }
        return date($format);
    }
}