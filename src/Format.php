<?php namespace Wongyip\PHPHelpers;

use Exception;
use Wongyip\PHPHelpers\Traits\FormatArray;
use Wongyip\PHPHelpers\Traits\FormatDateInterval;
use Wongyip\PHPHelpers\Traits\FormatDateTime;
use Wongyip\PHPHelpers\Traits\FormatFileSize;
use Wongyip\PHPHelpers\Traits\FormatString;

class Format
{
    use FormatArray, FormatDateTime, FormatDateInterval, FormatFileSize, FormatString;

    /**
     * @see FormatFileSize
     */
    public const WY_FILESIZE_UNITS_BINARY_CASUAL = 'KB,MB,GB,TB,PB,EB,ZB,YB';
    public const WY_FILESIZE_UNITS_BINARY_STRICT = 'KiB,MiB,GiB,TiB,PiB,EiB,ZiB,YiB';
    public const WY_FILESIZE_UNITS_METRIC_CASUAL = 'KB,MB,GB,TB,PB,EB,ZB,YB';
    public const WY_FILESIZE_UNITS_METRIC_STRICT = 'kB,MB,GB,TB,PB,EB,ZB,YB';

    /**
     * @param string $name
     * @param array $arguments
     * @return string|null
     * @throws Exception
     */
    public static function __callStatic(string $name, array $arguments): ?string
    {
        if (array_key_exists($name, self::$datetimeFormats)) {
            $dateTime = $arguments[0] ?? null;
            return self::dateTime($name, $dateTime);
        }

        throw new Exception(sprintf('Undefined method Format::%s() called.', $name));
    }
}