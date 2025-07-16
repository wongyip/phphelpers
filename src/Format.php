<?php namespace Wongyip\PHPHelpers;

use Exception;
use Wongyip\PHPHelpers\Traits\FormatDateInterval;
use Wongyip\PHPHelpers\Traits\FormatDateTime;
use Wongyip\PHPHelpers\Traits\FormatFileSizeTrait;
use Wongyip\PHPHelpers\Traits\FormatStringTrait;

class Format
{
    use FormatDateInterval, FormatDateTime, FormatFileSizeTrait, FormatStringTrait;

    /**
     * @see FormatFileSizeTrait
     */
    const WY_FILESIZE_UNITS_BINARY_CASUAL = 'KB,MB,GB,TB,PB,EB,ZB,YB';
    const WY_FILESIZE_UNITS_BINARY_STRICT = 'KiB,MiB,GiB,TiB,PiB,EiB,ZiB,YiB';
    const WY_FILESIZE_UNITS_METRIC_CASUAL = 'KB,MB,GB,TB,PB,EB,ZB,YB';
    const WY_FILESIZE_UNITS_METRIC_STRICT = 'kB,MB,GB,TB,PB,EB,ZB,YB';

    /**
     * @param $name
     * @param $arguments
     * @return string|null
     * @throws Exception
     */
    static function __callStatic($name, $arguments): ?string
    {
        if (key_exists($name, self::$datetimeFormats)) {
            $dateTime = $arguments[0] ?? null;
            return self::dateTime($name, $dateTime);
        }

        throw new Exception(sprintf('Undefined method Format::%s() called.', $name));
    }
    
}