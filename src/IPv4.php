<?php

namespace Wongyip\PHPHelpers;

class IPv4
{
    /**
     * Whether the input is a valid IPv4 address within the given lower and
     * upper boundaries.
     *
     * @param string $address
     * @param string $lower
     * @param string $upper
     * @return bool
     */
    public static function addressBetween(string $address, string $lower, string $upper): bool
    {
        if (self::validAddress($address)&& self::validAddress($lower) && self::validAddress($upper)) {
            $lower   = ip2long($lower);
            $upper   = ip2long($upper);
            $address = ip2long($address);
            return $address >= $lower && $address <= $upper;
        }
        return false;
    }

    /**
     * Whether the input is a valid IPv4 address in (one of) the given range.
     * Where the range can be a single value or multiple values (array or CSV)
     * of a valid * IPv4 address, a CIDR block notation, or a range between two
     * IP addresses * inclusively like '10.0.1.23-10.0.2.34'.
     *
     * @param string $input
     * @param string|array $range
     * @return bool
     *
     * @see IPv4::addressBetween() for IP addresses between two addresses inclusively.
     * @see IPv4::addressInCIRD() for CIDR notation only.
     * @see IPv4::addressInList() for IP addresses in CSV or array only.
     */
    public static function addressIn(string $input, string|array $range): bool
    {
        if (self::validAddress($input)) {

            // CSV to array
            if (is_string($range) && str_contains($range, ',')) {
                $range = array_map('trim', explode(',', $range));
            }

            // Recursive for array of ranges.
            if (is_array($range)) {
                foreach ($range as $r) {
                    if (IPv4::addressIn($input, $r)) {
                        return true;
                    }
                }
                return false;
            }

            // Range is a string now. ------------------------------------------

            /**
             * Range is CIDR.
             */
            if (self::validCIDR($range)) {
                return self::addressInCIDR($input, $range);
            }

            /**
             * Range between is two addresses.
             */
            if (str_contains($range, '-')) {
                $range = array_map('trim', explode('-', $range));
                if (count($range) === 2) {
                    [$lower, $upper] = $range;
                    return self::addressBetween($input, $lower, $upper);
                }
            }

            /**
             * Range is a IPv4 address (original input maybe a CSV or an array
             * of addresses).
             */
            if (self::validAddress($range)) {
                return $input === $range;
            }
        }
        return false;
    }

    /**
     * Whether the input is a valid IPv4 address in the given CIDR block. This
     * method accepts a single CIDR block only, use `addressIn()` method in case
     * of multiple CIDR blocks matching is needed.
     *
     * @param string $address
     * @param string $cidr
     * @return bool
     * @see https://stackoverflow.com/questions/594112/check-whether-or-not-a-cidr-subnet-contains-an-ip-address
     */
    public static function addressInCIDR(string $address, string $cidr): bool
    {
        if (self::validAddress($address) && self::validCIDR($cidr)) {
            list ($blkAddr, $prefix) = explode('/', $cidr);
            $address = ip2long($address);
            $blkAddr = ip2long($blkAddr);
            $mask = -1 << (32 - $prefix);
            $blkAddr &= $mask; # nb: in case the supplied subnet wasn't correctly aligned
            return ($address & $mask) == $blkAddr;
        }
        return false;
    }

    /**
     * Whether the input is a valid IPv4 address in the given list. Where the
     * list can be a single or multiple values (array or CSV) of a valid IPv4
     * address.
     *
     * @param string $input
     * @param string|array $list
     * @return bool
     */
    public static function addressInList(string $input, string|array $list): bool
    {
        $list = is_array($list) ? $list : array_map('trim', explode(',', $list));
        return in_array($input, $list);
    }

    /**
     * Whether the input is a valid IPv4 address, e.g. "192.168.0.1".
     *
     * Note: input in untyped, so that this also validate the type.
     *
     * @param mixed $input
     * @return bool
     */
    public static function validAddress(mixed $input): bool
    {
        return is_string($input) &&
            filter_var($input, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }

    /**
     * Whether the input is a valid CIDR notation, e.g. "192.168.0.1/24".
     *
     * Note: input in untyped, so that this also validate the type.
     *
     * @param mixed $input
     * @return bool
     */
    public static function validCIDR(mixed $input): bool
    {
        if (is_string($input)) {
            $cidr = explode('/', $input);
            if (count($cidr) === 2) {
                [$addr, $prefix] = $cidr;
                return
                    filter_var($addr, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) &&
                    is_numeric($prefix) &&
                    $prefix >= 0 &&
                    $prefix <= 32;
            }
        }
        return false;
    }
}