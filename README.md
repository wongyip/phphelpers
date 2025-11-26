# PHP Helpers

A collection of utility PHP classes designed for everyday development tasks. This library provides convenient static methods for formatting and converting various data types.

## Classes

### Format
A comprehensive formatting utility class with support for:
- **Array formatting** - Convert arrays to text, flatten nested structures
- **DateTime formatting** - Predefined formats for MySQL, JavaScript, Outlook, and more
- **File size formatting** - Human-readable file sizes with binary/metric prefixes
- **String formatting** - Case conversions (camel, kebab, snake, studly), smart capitalization
- **Date interval formatting** - Human-readable time periods

### Other Classes
- **ICAL** - Generate standardized ICAL format calendars
- **Convert** - Data conversion utilities
- **CSS** - CSS-related helpers
- **IPv4** - IPv4 address utilities

### Deprecated
- **DT** & **DTFormat** - Additional date/time utilities

## Quick Start

```php
use Wongyip\PHPHelpers\Format;

// Format file sizes
echo Format::fileSize(1536); // "1.5 KB"

// Format dates
echo Format::MySQL(); // "2023-12-25 15:30:45"

// Convert strings
echo Format::camel('hello-world'); // "helloWorld"

// Format arrays to text
$data = ['name' => 'John', 'age' => 30];
echo Format::toText($data);
// name: John
// age : 30
```

## Documentation

- [Format Class Documentation](docs/Format.php.md)
- [ICAL Class Documentation](docs/ICAL.php.md)

## Installation

```bash
composer require wongyip/phphelpers
```

## Requirements

- PHP 8.0 or higher
