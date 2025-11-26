# Format::class

## Purpose
A comprehensive formatting utility class that provides static methods for formatting various data types including arrays, dates/times, file sizes, and strings. The class uses multiple traits to organize functionality and supports both predefined and custom formatting options.

## Features

### Array Formatting
- **flatten()** - Flattens nested arrays into a single-level array
- **toText()** - Converts arrays to aligned key-value text format with customizable formatting

### DateTime Formatting
- **dateTime()** - Formats dates using predefined or custom formats
- **Magic methods** for common date formats (MySQL, JavaScript, Outlook, etc.)
- **testFormatDateTime()** - Development helper to test all predefined formats

### File Size Formatting
- **fileSize()** - Converts bytes to human-readable format (e.g., "1.5 MB")
- **fileSizeStrict()** - Strict version that throws exceptions for invalid input
- Support for binary (1024) and metric (1000) prefixes
- Support for strict (KiB, MiB) and casual (KB, MB) units

### String Formatting
- **camel()** - Converts to camelCase
- **kebab()** - Converts to kebab-case
- **snake()** - Converts to snake_case
- **studly()** - Converts to StudlyCase
- **smartCaps()** - Smart capitalization for titles and headers
- **indent()** - Adds indentation to strings
- **keysCase()** - Converts array key naming schemes

### Date Interval Formatting
- **dateInterval()** - Formats DateInterval objects to human-readable strings
- **dateIntervalShortForm()** - Compact version with abbreviated units

## Usage Examples

### Array Formatting
```php
use Wongyip\PHPHelpers\Format;

// Flatten nested arrays
$nested = [1, [2, 3], [4, [5, 6]]];
$flat = Format::flatten($nested);
// Result: [1, 2, 3, 4, 5, 6]

// Convert array to aligned text
$data = ['name' => 'John', 'email' => 'john@example.com', 'age' => 30];
$text = Format::toText($data);
// Result:
// name : John
// email: john@example.com
// age  : 30
```

### DateTime Formatting
```php
use Wongyip\PHPHelpers\Format;

// Using predefined formats
$mysql = Format::MySQL();                    // 2023-12-25 15:30:45
$filename = Format::Filename();              // 2023-12-25-15-30-45
$outlook = Format::Outlook();                // Monday, December 25, 2023 3:30 PM

// Using custom format
$custom = Format::dateTime('Y/m/d H:i', new DateTime());

// With specific datetime
$formatted = Format::MySQL('2023-12-25 15:30:45');
```

### File Size Formatting
```php
use Wongyip\PHPHelpers\Format;

// Basic usage
$size = Format::fileSize(1536);              // "1.5 KB"
$size = Format::fileSize(1048576);           // "1 MB"

// With different options
$binary = Format::fileSize(1024, true);      // "1 KiB" (binary, strict)
$metric = Format::fileSize(1000, false);     // "1 kB" (metric, strict)
$casual = Format::fileSize(1024, true, true); // "1 KB" (binary, casual)
```

### String Formatting
```php
use Wongyip\PHPHelpers\Format;

// Case conversions
$camel = Format::camel('hello-world');        // "helloWorld"
$kebab = Format::kebab('HelloWorld');         // "hello-world"
$snake = Format::snake('HelloWorld');         // "hello_world"
$studly = Format::studly('hello-world');      // "HelloWorld"

// Smart capitalization
$title = Format::smartCaps('the quick brown fox'); // "The Quick Brown Fox"

// String indentation
$indented = Format::indent("line1\nline2", 2); // "        line1\n        line2"
```

### Date Interval Formatting
```php
use Wongyip\PHPHelpers\Format;

$interval = new DateInterval('P1Y2M3DT4H5M6S');
$readable = Format::dateInterval($interval);
// Result: "1 year 2 months 3 days 4 hours 5 minutes and 6 seconds"

$short = Format::dateIntervalShortForm($interval);
// Result: "1 yr 2 months 3 days 4 hrs 5 mins & 6 secs"
```

## Predefined DateTime Formats

| Method | Format | Example Output |
|--------|--------|----------------|
| `MySQL()` | Y-m-d H:i:s | 1970-12-31 23:59:59 |
| `MySqlDate()` | Y-m-d | 1970-12-31 |
| `MySqlTime()` | H:i:s | 23:59:59 |
| `Filename()` | Y-m-d-H-i-s | 2010-12-31-23-59-59 |
| `FilenameCompact()` | Ymd-His | 20101231-235959 |
| `JavaScript()` | F j, Y, H:i:s | March 10, 2001, 23:59:59 |
| `ShortDate()` | Y-m-d | 1970-12-31 |
| `SimpleDate()` | M j, Y (D) | Jan 1, 2013 (Tue) |
| `SimpleDateTime()` | M j, Y (D) g:i A | Jan 1, 2013 (Tue) 1:59 PM |
| `EnglishDate()` | F j, Y | January 1, 2013 |
| `Outlook()` | l, F j, Y g:i A | Tuesday, June 24, 2014 1:59 PM |

## File Size Units

### Binary Prefixes (Default)
- **Strict**: KiB, MiB, GiB, TiB, PiB, EiB, ZiB, YiB (base 1024)
- **Casual**: KB, MB, GB, TB, PB, EB, ZB, YB (base 1024)

### Metric Prefixes
- **Strict**: kB, MB, GB, TB, PB, EB, ZB, YB (base 1000)
- **Casual**: KB, MB, GB, TB, PB, EB, ZB, YB (base 1000)

## Constants
- `WY_FILESIZE_UNITS_BINARY_CASUAL`
- `WY_FILESIZE_UNITS_BINARY_STRICT`
- `WY_FILESIZE_UNITS_METRIC_CASUAL`
- `WY_FILESIZE_UNITS_METRIC_STRICT`

## Error Handling
- The `fileSize()` method returns "0 Byte" for invalid input
- The `fileSizeStrict()` method throws exceptions for negative values
- DateTime formatting returns `null` for invalid input
- Magic method calls throw exceptions for undefined methods

## Dependencies
- Uses traits from `Wongyip\PHPHelpers\Traits` namespace
- Requires PHP DateTime and DateInterval classes
- Some string methods may depend on external Convert class