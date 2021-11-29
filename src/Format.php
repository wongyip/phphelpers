<?php namespace Wongyip\PHPHelpers;

use Wongyip\PHPHelpers\Traits\FormatFileSizeTrait;
use Wongyip\PHPHelpers\Traits\FormatStringTrait;

class Format
{
    use FormatFileSizeTrait, FormatStringTrait;

    // For FormatFileSizeTrait.
    const WY_FILESIZE_UNITS_BINARY_CASUAL = 'KB,MB,GB,TB,PB,EB,ZB,YB';
    const WY_FILESIZE_UNITS_BINARY_STRICT = 'KiB,MiB,GiB,TiB,PiB,EiB,ZiB,YiB';
    const WY_FILESIZE_UNITS_METRIC_CASUAL = 'KB,MB,GB,TB,PB,EB,ZB,YB';
    const WY_FILESIZE_UNITS_METRIC_STRICT = 'kB,MB,GB,TB,PB,EB,ZB,YB';
    
}